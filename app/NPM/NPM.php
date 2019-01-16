<?php

namespace App\NPM;

/**
 * Class NPM
 * @package App\NPM
 */
class NPM
{
    /**
     * Determines whether NPM (Node Package Manager) is installed in the
     * environment.
     *
     * @return bool
     */
    public static function exists(): bool
    {
        exec('npm -v', $result, $exit_code);

        return (int)$exit_code === 0 ? true : false;
    }

    /**
     * Performs an installation of NPM (Node Package Manager) in the
     * environment.
     *
     * @return void
     *
     * @throws \App\NPM\InstallationFailureException
     */
    public static function install(): void
    {
        if (is_windows()) {
            throw new InstallationFailureException("Failed To Install NPM.");
        }

        $MAX_EXECUTION_TIME = 1800; // "30 Mins" for slow internet connections.

        set_time_limit($MAX_EXECUTION_TIME);

         shell_exec('touch ~/.bash_profile');

         shell_exec('curl -o- https://raw.githubusercontent.com/creationix/nvm/v0.34/install.sh | NVM_DIR="nvm" bash');
         shell_exec('nvm install node');
         shell_exec('nvm use node');

         //
    }

    /**
     * Performs an installation of Node packages in the supplied
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
        shell_exec("npm install");

        chdir($CURRENT_WORKING_DIRECTORY);
    }

    /**
     * Determines whether the application requires the Node packages
     * to be installed.
     *
     * @param  string $directory
     *
     * @return bool
     */
    public static function packagesExists(string $directory): bool
    {
        return file_exists($directory . "/package.json") ? true : false;
    }

    /**
     * Determines whether the Node packages has been installed in the
     * supplied directory.
     *
     * @param  string $directory
     *
     * @return bool
     */
    public static function packagesInstalled(string $directory): bool
    {
        return file_exists($directory . "/node_modules/") ? true : false;
    }
}
