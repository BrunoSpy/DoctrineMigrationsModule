<?php
/**
 * Created by JetBrains PhpStorm.
 * User: Nik
 * Date: 09.03.12
 * Time: 16:05
 * To change this template use File | Settings | File Templates.
 */
namespace DoctrineMigrationsModule;

use Doctrine\DBAL\Migrations\Configuration\Configuration AS Migrations_Configuration;
use DoctrineORMModule\Doctrine\ORM\Connection;
use Doctrine\DBAL\Migrations\OutputWriter;

class Configuration extends Migrations_Configuration
{

    private $_isRegistered = false;

    public function __construct(Connection $connection, OutputWriter $outputWriter=null)
    {
        parent::__construct($connection->getInstance());
        if ($outputWriter === null) {
            $outputWriter = new OutputWriter();
        }
        $this->outputWriter = $outputWriter;

        /*foreach ($options as $key=>$value) {
            switch($key) {
                case 'mirgations_directory':
                    $this->setMigrationsDirectory($value);
                    break;
                case 'migrations_namespace':
                    $this->setMigrationsNamespace($value);
                    break;
            }
        }*/

    }

    public function setMigrationsDirectory($migrationsDirectory)
    {
        parent::setMigrationsDirectory($migrationsDirectory);
        $this->_registerMigrations();
    }

    public function setMigrationsNamespace($migrationsNamespace)
    {
        parent::setMigrationsNamespace($migrationsNamespace);
        $this->_registerMigrations();
    }

    private function _registerMigrations()
    {

        if ($this->_isRegistered) {
            return true;
        }

        $directory = $this->getMigrationsDirectory();
        $namespace = $this->getMigrationsNamespace();
        if (!$directory || !$namespace) {
            return false;
        }


        $this->registerMigrationsFromDirectory($directory);
        $this->_isRegistered = true;
        return true;
    }
}