## Welcome to the DoctrineMigrationsModule for Zend Framework 2!

DoctrineMigrationsModule add migration commands to DoctrineModule Cli!

Fork of [MurgaNikolay’s DoctrineMigrationsModule](https://github.com/MurgaNikolay/DoctrineMigrationsModule) with updated dependencies.


## Istallation

### Composer

1. Install the package

    ```sh
    # Remove existing doctrine-migrations-module package, if you have one installed
    composer remove murganikolay/doctrine-migrations-module
    # Change doctrine/doctrine-orm-module version to ~0.10
    editor composer.json
    # Let doctrine update
    composer update doctrine/*
    # Add this fork’s repository
    composer config repositories.doctrine-migrations-module vcs https://github.com/DietLabs/DoctrineMigrationsModule
    # … and finally
    composer require DietLabs/doctrine-migrations-module:dev-master
    ```
    
2. Add DoctrineMigrationsModule to your `config/application.co

### Manual

Not support!

### Configuration

Change you Application config like this:

    return array(
        ...
        'doctrine' => array(
            'migrations' => array(
                'migrations_table' => 'migrations',
                'migrations_namespace' => 'Application',
                'migrations_directory' => 'data/migrations',
            ),
        ),
        ...
    );
