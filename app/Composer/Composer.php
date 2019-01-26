<?php

namespace Deployer\Composer;

/**
 * Class Composer
 * @package Deployer\Composer
 */
class Composer
{
    /**
     * Determines whether Composer is installed in the environment.
     *
     * @return bool
     */
    public static function exists(): bool
    {
        return file_exists(__ROOT_DIRECTORY__ . "/bin/composer") ? true : false;
    }

    /**
     * Performs an installation of Composer in the environment.
     *
     * @return void
     */
    public static function install(): void
    {
        shell_exec("php -r \"copy('https://getcomposer.org/installer', 'composer-setup.php');\"");
        shell_exec("php composer-setup.php --install-dir=bin --filename=composer");
        shell_exec("php -r \"unlink('composer-setup.php');\"");
    }

    /**
     * Performs an installation of Composer packages in the supplied
     * directory.
     *
     * @param  string $directory
     *
     * @return void
     */
    public static function installPackages(string $directory): void
    {
        $CURRENT_WORKING_DIRECTORY = getcwd();

        chdir($directory);

        $MAX_EXECUTION_TIME = 1800; // "30 Mins" for slow internet connections.

        set_time_limit($MAX_EXECUTION_TIME);
        shell_exec("php bin/composer install");

        chdir($CURRENT_WORKING_DIRECTORY);
    }

    /**
     * Determines whether the application requires the Composer packages
     * to be installed.
     *
     * @param  string $directory
     *
     * @return bool
     */
    public static function packagesExists(string $directory): bool
    {
        return file_exists($directory . "/composer.json") ? true : false;
    }

    /**
     * Determines whether the Composer packages has been installed in the
     * supplied directory.
     *
     * @param  string $directory
     *
     * @return bool
     */
    public static function packagesInstalled(string $directory): bool
    {
        return file_exists($directory . "/vendor/") ? true : false;
    }
}