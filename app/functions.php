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

if (!function_exists("npm_required")) {
    /**
     * Determines whether the source application requires the Node Modules
     * to be installed.
     *
     * @return bool
     */
    function npm_required(): bool
    {
        $path = __SRC_DIRECTORY__ . "/package.json";

        if (file_exists($path)) {
            return true;
        }

        return false;
    }
}