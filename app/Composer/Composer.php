<?php

namespace App\Composer;

/**
 * Class Composer
 * @package App\Composer
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
        exec('composer -v', $result, $exit_code);

        return (int)$exit_code === 0 ? true : false;
    }

    /**
     * Performs an installation of Composer in the environment.
     *
     * @return void
     *
     * @throws \App\Composer\InstallationFailureException
     */
    public static function install(): void
    {
        if (is_windows()) {
            require_once "InstallationFailureException.php";

            throw new InstallationFailureException("Failed To Install Composer.");
        }

        shell_exec("sh installer.sh");
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
        shell_exec("composer install");

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