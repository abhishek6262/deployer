<?php

namespace Deployer\Recipes\Defaults\SetupNodeJS;

use abhishek6262\NodePHP\NPM;
use Deployer\Container;
use Deployer\Recipes\Recipe;
use Deployer\Response\Template;
use Deployer\Response\View;
use Deployer\Routing\RouteCollection;

/**
 * Class SetupNodeJSRecipe
 * @package Deployer\Recipes\Defaults\SetupNodeJS
 */
class SetupNodeJSRecipe extends Recipe
{
    /**
     * The order on which the recipe will be executed.
     *
     * @var int
     */
    public $order = 200;

    /**
     * The list of routes for the recipe.
     *
     * @return array
     */
    public function routes(): array
    {
        return [
            [
                'GET',
                '/node',
                function (RouteCollection $routes, Container $container) {
                    $node = $container->resolve('node');

                    if ($node->exists()) {
                        \redirect($routes->nextViewRouteUrl());
                    }

                    if (isset($_GET['installation']) && $_GET['installation'] === 'failed') {
                        $response = new Template(
                            __DIR__ . '/SetupNodeJSFails.php',
                            [
                                'routes' => $routes
                            ]
                        );
                    } else {
                        $response = new Template(
                            __DIR__ . '/SetupNodeJSIntro.php',
                            [
                                'routes' => $routes
                            ]
                        );
                    }

                    return new View($response);
                },
                'nodejs'
            ],

            [
                'POST',
                '/node',
                function (RouteCollection $routes, Container $container) {
                    $node = $container->resolve('node');
                    $url = $routes->nextViewRouteUrl();

                    if (!$node->exists()) {
                        $url = $routes->generate('nodejs');

                        try {
                            $response = $node->install();

                            if ((int)$response->statusCode() !== 0) {
                                $url .= '?' . http_build_query(['installation' => 'failed']);
                            } else {
                                $environment = new \abhishek6262\NodePHP\System\Environment(__ROOT_DIRECTORY__, __BIN_DIRECTORY__);
                                $npm = new NPM($environment);

                                $npm->installPackages();
                            }
                        } catch (\Exception $exception) {
                            $url .= '?' . http_build_query(['installation' => 'failed']);
                        }
                    }

                    \redirect($url);
                },
                'nodejs.setup'
            ]
        ];
    }
}