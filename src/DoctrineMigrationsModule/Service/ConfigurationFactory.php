<?php

namespace DoctrineMigrationsModule\Service;

use Interop\Container\ContainerInterface;
use Interop\Container\Exception\ContainerException;
use Laminas\ServiceManager\Exception\ServiceNotCreatedException;
use Laminas\ServiceManager\Exception\ServiceNotFoundException;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Laminas\ServiceManager\ServiceLocatorInterface;
use DoctrineMigrationsModule\Migrations\Configuration;

/**
 * Created by IntelliJ IDEA.
 * User: Nikolay
 * Date: 17.01.13
 * Time: 16:00
 * To change this template use File | Settings | File Templates.
 */


class ConfigurationFactory implements FactoryInterface
{
    /**
     * Create an object
     *
     * @param  ContainerInterface $container
     * @param  string $requestedName
     * @param  null|array $options
     * @return object
     * @throws ServiceNotFoundException if unable to resolve the service.
     * @throws ServiceNotCreatedException if an exception is raised when
     *     creating a service.
     * @throws ContainerException if any other error occurs
     */
    public function __invoke(ContainerInterface $container, $requestedName, array $options = null)
    {
        $config = $container->get('Config');
        $config = $config['doctrine']['migrations'];

        if (isset($config['connection']) && $container->has($config['connection'])) {
            $connection = $container->get($config['connection']);
        } else {
            $connection = $container->get('doctrine.connection.orm_default');
        }
        unset($config['connection']);

        if (isset($config['output_writer']) && $container->has($config['output_writer'])) {
            $outputWriter = $container->get($config['output_writer']);
        } else {
            $outputWriter = null;
        }
        unset($config['output_writer']);

        $configuration = new Configuration($connection, $outputWriter);

        foreach ($config as $key => $value) {
            $setter = 'set' . str_replace(' ', '', ucwords(str_replace('_', ' ', $key)));
            if (!method_exists($configuration, $setter)) {
                continue;
            }
            $configuration->{$setter}($value);
        }

        return $configuration;
    }
}
