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

        exec('touch ~/.bash_profile', $result, $code);

        exec('
            export NVM_DIR=$HOME/nvm &&
            curl -o- https://raw.githubusercontent.com/creationix/nvm/v0.33.1/install.sh | bash &&
            [ -s "$NVM_DIR/nvm.sh" ] &&
            \. "$NVM_DIR/nvm.sh" &&
            nvm install node &&
            nvm use node
        ', $result, $code);
        print_r($result);
        echo PHP_EOL . $code;
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
