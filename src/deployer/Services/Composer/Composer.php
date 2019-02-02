<?php

namespace Deployer\Services\Composer;

/**
 * Class Composer
 * @package Deployer\Services\Composer
 */
class Composer
{
    /**
     * @var string
     */
    static $binPath = '/bin';

    /**
     * @var string
     */
    static $rootPath = '/';

    /**
     * Determines whether Composer is installed in the environment.
     *
     * @return bool
     */
    public static function exists(): bool
    {
        return file_exists(self::$binPath . "/composer") ? true : false;
    }

    /**
     * Performs an installation of Composer in the environment.
     *
     * @return void
     */
    public static function install(): void
    {
        $CURRENT_WORKING_DIRECTORY = getcwd();

        chdir(self::$rootPath);

        $MAX_EXECUTION_TIME = 1800; // "30 Mins" for slow internet connections.

        set_time_limit($MAX_EXECUTION_TIME);

        shell_exec("php -r \"copy('https://getcomposer.org/installer', 'composer-setup.php');\"");
        shell_exec("php composer-setup.php --install-dir=" . self::$binPath . " --filename=composer");
        shell_exec("php -r \"unlink('composer-setup.php');\"");

        chdir($CURRENT_WORKING_DIRECTORY);
    }

    /**
     * Performs an installation of Composer packages in the supplied
     * directory.
     *
     * @param  string $directory
     *
     * @return void
     */
    public static function installPackages(string $directory = ''): void
    {
        $CURRENT_WORKING_DIRECTORY = getcwd();

        if (empty($directory)) {
            $directory = self::$rootPath;
        }

        chdir($directory);

        $MAX_EXECUTION_TIME = 1800; // "30 Mins" for slow internet connections.

        set_time_limit($MAX_EXECUTION_TIME);

        shell_exec("php " . self::$binPath . "/composer install");

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
    public static function packagesExists(string $directory = ''): bool
    {
        if (empty($directory)) {
            $directory = self::$rootPath;
        }

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
    public static function packagesInstalled(string $directory = ''): bool
    {
        if (empty($directory)) {
            $directory = self::$rootPath;
        }

        return file_exists($directory . "/vendor/") ? true : false;
    }

    /**
     * Set the path on which the composer binary will be installed.
     *
     * @param string $path
     *
     * @return void
     */
    public static function setBinPath($path = ''): void
    {
        self::$binPath = realpath($path);
    }

    /**
     * Set the path at which the composer commands will be executed.
     *
     * @param string $path
     *
     * @return void
     */
    public static function setRootPath($path = ''): void
    {
        self::$rootPath = realpath($path);
    }
}