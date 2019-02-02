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

        $this->bind('composer', new \Composer(__PROJECT_DIRECTORY__, __BIN_DIRECTORY__));

        // Next, we'll register the composer routes in the application
        // so composer can perform its tasks in case the composer or the
        // packages not found and needed to be installed.

        $this->registerComposerRoute();
    }

    /**
     * Registers the composer routes in the application.
     *
     * @return void
     */
    protected function registerComposerRoute()
    {
        $routes = $this->resolve('routes');

        /** @noinspection PhpUndefinedMethodInspection */
        $routes->add(
            'GET',
            '/deployer/src/composer/install',
            function () use ($routes) {
                // 
            },
            'composer.install'
        );

        /** @noinspection PhpUndefinedMethodInspection */
        $routes->add(
            'POST',
            '/deployer/src/composer/install',
            function () use ($routes) {
                // 
            }
        );
    }
}