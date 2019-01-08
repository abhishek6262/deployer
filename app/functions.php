<?php

if (!function_exists("config")) {
    /**
     * Returns the configuration data for the application.
     *
     * @param  string $key
     *
     * @return string|null
     */
    function config($key): ?string
    {
        $str = file_get_contents(__ROOT_DIRECTORY__ . '/config.json');
        $data = json_decode($str, true);

        return array_key_exists($key, $data) ? $data[$key] : null;
    }
}

if (!function_exists("composer_exists")) {
    /**
     * Determines whether Composer is installed in the environment.
     *
     * @return bool
     */
    function composer_exists(): bool
    {
        exec('composer -v', $result, $exit_code);

        return (int)$exit_code === 0 ? true : false;
    }
}

if (!function_exists("composer_install")) {
    /**
     * Performs an installation of Composer in the environment.
     *
     * @return void
     *
     * @throws \App\Composer\InstallationFailureException
     */
    function composer_install(): void
    {
        if (is_windows()) {
            require_once __APP_DIRECTORY__ . "/Composer/InstallationFailureException.php";

            throw new \App\Composer\InstallationFailureException("Failed To Install Composer.");
        }

        $installer = require_once __APP_DIRECTORY__ . "/Composer/installer.sh";

        shell_exec($installer);
    }
}

if (!function_exists("composer_packages_exists")) {
    /**
     * Determines whether the Composer packages has been installed in the
     * supplied directory.
     *
     * @param  string $directory
     *
     * @return bool
     */
    function composer_packages_exists($directory = __ROOT_DIRECTORY__): bool
    {
        return file_exists($directory . "/vendor/") ? true : false;
    }
}

if (!function_exists("composer_packages_install")) {
    /**
     * Performs an installation of Composer packages in the supplied
     * directory.
     *
     * @param  string $directory
     *
     * @return void
     */
    function composer_packages_install($directory = __ROOT_DIRECTORY__): void
    {
        $CURRENT_WORKING_DIRECTORY = getcwd();

        chdir($directory);

        $MAX_EXECUTION_TIME = 1800; // "30 Mins" for slow internet connections.

        set_time_limit($MAX_EXECUTION_TIME);
        shell_exec("composer install");

        chdir($CURRENT_WORKING_DIRECTORY);
    }
}

if (!function_exists("composer_packages_required")) {
    /**
     * Determines whether the application requires the Composer packages
     * to be installed.
     *
     * @param  string $directory
     *
     * @return bool
     */
    function composer_packages_required($directory = __ROOT_DIRECTORY__): bool
    {
        return file_exists($directory . "/composer.json") ? true : false;
    }
}

if (!function_exists("composer_required")) {
    /**
     * Determines whether the application requires the Composer to be
     * installed.
     *
     * @return bool
     */
    function composer_required(): bool
    {
        return (composer_packages_required() || composer_packages_required(__SRC_DIRECTORY__));
    }
}

if (!function_exists("is_windows")) {
    /**
     * Determines whether the environment on which the application running
     * is Windows.
     *
     * @return bool
     */
    function is_windows(): bool
    {
        if (strpos(strtoupper(PHP_OS), "WIN") !== false) {
            return true;
        }

        return false;
    }
}

if (!function_exists("npm_exists")) {
    /**
     * Determines whether NPM is installed in the environment.
     *
     * @return bool
     */
    function npm_exists(): bool
    {
        exec('npm -v', $result, $exit_code);

        return (int)$exit_code === 0 ? true : false;
    }
}

if (!function_exists("npm_install")) {
    /**
     * Performs an installation of Node JS and NPM in the environment.
     *
     * @return void
     *
     * @throws \App\NPM\InstallationFailureException
     */
    function npm_install(): void
    {
        if (is_windows()) {
            throw new \App\NPM\InstallationFailureException("Failed To Install NPM.");
        }

        // 
    }
}

if (!function_exists("npm_packages_exists")) {
    /**
     * Determines whether the NPM packages has been installed in the
     * supplied directory.
     *
     * @param  string $directory
     *
     * @return bool
     */
    function npm_packages_exists($directory = __SRC_DIRECTORY__): bool
    {
        return file_exists($directory . "/node_modules/") ? true : false;
    }
}

if (!function_exists("npm_packages_install")) {
    /**
     * Performs an installation of NPM packages in the supplied directory.
     *
     * @param  string $directory
     *
     * @return void
     */
    function npm_packages_install($directory = __SRC_DIRECTORY__): void
    {
        $CURRENT_WORKING_DIRECTORY = getcwd();

        chdir($directory);

        $MAX_EXECUTION_TIME = 1800; // "30 Mins" for slow internet connections.

        set_time_limit($MAX_EXECUTION_TIME);
        shell_exec("npm install");

        chdir($CURRENT_WORKING_DIRECTORY);
    }
}

if (!function_exists("npm_packages_required")) {
    /**
     * Determines whether the application requires the Node Modules
     * to be installed.
     *
     * @param  string $directory
     *
     * @return bool
     */
    function npm_packages_required($directory = __ROOT_DIRECTORY__): bool
    {
        return file_exists($directory . "/package.json") ? true : false;
    }
}

if (!function_exists("npm_required")) {
    /**
     * Determines whether the application requires the NPM
     * (Node Package Manager) to be installed.
     *
     * @param  string $directory
     *
     * @return bool
     */
    function npm_required(): bool
    {
        return (npm_packages_required() || npm_packages_required(__SRC_DIRECTORY__));
    }
}