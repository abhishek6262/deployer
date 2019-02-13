<?php

namespace Deployer\Services\Node;

use abhishek6262\NodePHP\NPM;
use abhishek6262\NodePHP\System\Environment;

/**
 * Trait NodeTrait
 * @package Deployer\Services\Node
 */
trait NodeTrait
{
    /**
     * Registers npm service in the application.
     *
     * @return void
     */
    public function bindNPM()
    {
        // We'll begin with setting the path of the root directory and
        // binary installation directory of the project where NPM will
        // execute its commands.

        $environment = new Environment(__PROJECT_DIRECTORY__, __BIN_DIRECTORY__);

        $this->bind('npm', new NPM($environment));

        // Next, we'll register the node routes in the application
        // so node can perform its tasks in case the node or the
        // packages not found and needed to be installed.

        $this->registerNodeRoutes();
    }

    /**
     * Registers the Node routes in the application.
     *
     * @return void
     */
    protected function registerNodeRoutes()
    {
        $routes = $this->resolve('routes');

        /** @noinspection PhpUndefinedMethodInspection */
        $routes->add(
            'GET',
            '/deployer/src/node/install',
            function () use ($routes) {
                //
            },
            'node.install'
        );

        /** @noinspection PhpUndefinedMethodInspection */
        $routes->add(
            'POST',
            '/deployer/src/node/install',
            function () use ($routes) {
                //
            }
        );
    }
}