<?php

namespace Deployer\Services\Composer;

require_once 'Composer.php';

/**
 * Trait ComposerTrait
 * @package Deployer\Services\Composer
 */
trait ComposerTrait
{
    /**
     * Registers composer service in the application.
     *
     * @return void
     */
    public function bindComposer()
    {
        // We'll begin with setting the path of the root directory and
        // binary installation directory of the project where Composer
        // will execute its commands.

        Composer::setBinPath(__BIN_DIRECTORY__);
        Composer::setRootPath(__ROOT_DIRECTORY__);

        $this->bind('composer', Composer::class);

        // Next, we'll register the composer routes in the application
        // so composer can perform its tasks in case the composer or the
        // packages not found and needed to be installed.

        $this->registerComposerRoute();
        $this->validateComposerInstallation();
    }

    /**
     * Registers the composer routes in the application.
     *
     * @return void
     */
    protected function registerComposerRoute()
    {
        $routes = $this->resolve('routes');

        $routes->add(
            'GET',
            '/deployer/src/composer/install',
            function () use ($routes) {
                // 
            },
            'composer.install'
        );

        $routes->add(
            'POST',
            '/deployer/src/composer/install',
            function () use ($routes) {
                // 
            }
        );
    }

    /**
     * Makes sure that the composer is installed in the system before
     * proceeding with the application.
     *
     * @return void
     */
    protected function validateComposerInstallation(): void
    {
        $route = $this->resolve('routes')->generate('composer.install');

        if (! Composer::exists() && $_SERVER['REQUEST_URI'] !== $route) {
            redirect($route);
        }
    }
}