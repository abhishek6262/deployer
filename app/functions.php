<?php

if (!function_exists("config")) {
    /**
     * Returns the configuration data for the application.
     *
     * @param  string $key
     *
     * @return string|null
     */
    function config(string $key): ?string
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
        return \Deployer\Composer\Composer::exists();
    }
}

if (!function_exists("composer_install")) {
    /**
     * Performs an installation of Composer in the environment.
     *
     * @return void
     *
     * @throws \Deployer\Composer\InstallationFailureException
     */
    function composer_install(): void
    {
        \Deployer\Composer\Composer::install();
    }
}

if (!function_exists("composer_packages_exists")) {
    /**
     * Determines whether the application requires the Composer packages
     * to be installed.
     *
     * @param  string $directory
     *
     * @return bool
     */
    function composer_packages_exists(string $directory = __ROOT_DIRECTORY__): bool
    {
        return \Deployer\Composer\Composer::packagesExists($directory);
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
    function composer_packages_install(string $directory = __ROOT_DIRECTORY__): void
    {
        \Deployer\Composer\Composer::installPackages($directory);
    }
}

if (!function_exists("composer_packages_installed")) {
    /**
     * Determines whether the Composer packages has been installed in the
     * supplied directory.
     *
     * @param  string $directory
     *
     * @return bool
     */
    function composer_packages_installed(string $directory = __ROOT_DIRECTORY__): bool
    {
        return \Deployer\Composer\Composer::packagesInstalled($directory);
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
        return (composer_packages_exists() || composer_packages_exists(__SRC_DIRECTORY__));
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
     * Determines whether NPM (Node Package Manager) is installed in the
     * environment.
     *
     * @return bool
     */
    function npm_exists(): bool
    {
        return \Deployer\NPM\NPM::exists();
    }
}

if (!function_exists("npm_install")) {
    /**
     * Performs an installation of NPM (Node Package Manager) in the
     * environment.
     *
     * @return void
     *
     * @throws \Deployer\NPM\InstallationFailureException
     */
    function npm_install(): void
    {
        \Deployer\NPM\NPM::install();
    }
}

if (!function_exists("npm_packages_exists")) {
    /**
     * Determines whether the application requires the Node packages
     * to be installed.
     *
     * @param  string $directory
     *
     * @return bool
     */
    function npm_packages_exists(string $directory = __ROOT_DIRECTORY__): bool
    {
        return \Deployer\NPM\NPM::packagesExists($directory);
    }
}

if (!function_exists("npm_packages_install")) {
    /**
     * Performs an installation of Node packages in the supplied
     * directory.
     *
     * @param  string $directory
     *
     * @return void
     */
    function npm_packages_install(string $directory = __ROOT_DIRECTORY__): void
    {
        \Deployer\NPM\NPM::installPackages($directory);
    }
}

if (!function_exists("npm_packages_installed")) {
    /**
     * Determines whether the Node packages has been installed in the
     * supplied directory.
     *
     * @param  string $directory
     *
     * @return bool
     */
    function npm_packages_installed(string $directory = __ROOT_DIRECTORY__): bool
    {
        return \Deployer\NPM\NPM::packagesInstalled($directory);
    }
}

if (!function_exists("npm_required")) {
    /**
     * Determines whether the application requires the NPM
     * (Node Package Manager) to be installed.
     *
     * @return bool
     */
    function npm_required(): bool
    {
        return (npm_packages_exists() || npm_packages_exists(__SRC_DIRECTORY__));
    }
}