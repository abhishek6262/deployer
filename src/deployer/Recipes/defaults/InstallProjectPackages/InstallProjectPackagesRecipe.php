<?php

namespace Deployer\Recipes\Defaults\InstallProjectPackages;

use abhishek6262\Composer\Composer;
use Deployer\Container;
use Deployer\Recipes\Recipe;
use Deployer\Response\Template;
use Deployer\Response\View;
use Deployer\Routing\RouteCollection;

/**
 * Class InstallProjectPackagesRecipe
 * @package Deployer\Recipes\Defaults\InstallProjectPackages
 */
class InstallProjectPackagesRecipe extends Recipe
{
    /**
     * The order on which the recipe will be executed.
     *
     * @var int
     */
    public $order = 300;

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
                '/packages',
                function (RouteCollection $routes, Container $container) {
                    $composer = $container->resolve('composer');
                    $npm = $container->resolve('npm');

                    if (!$composer->packagesExists() && !$npm->packagesExists()) {
                        \redirect($routes->nextViewRouteUrl());
                    }

                    if (isset($_GET['installation']) && $_GET['installation'] === 'failed') {
                        $response = new Template(
                            __DIR__ . '/InstallProjectPackagesFails.php',
                            [
                                'routes' => $routes
                            ]
                        );
                    } else {
                        $response = new Template(
                            __DIR__ . '/InstallProjectPackagesIntro.php',
                            [
                                'composer' => $composer,
                                'npm' => $npm,
                                'routes' => $routes
                            ]
                        );
                    }

                    return new View($response);
                },
                'packages'
            ],

            [
                'POST',
                '/packages',
                function (RouteCollection $routes, Container $container) {
                    $composer = $container->resolve('composer');
                    $npm = $container->resolve('npm');

                    $query = [];

                    if (!$composer->packagesExists()) {
                        $c_response = $composer->installPackages();

                        if ((int)$c_response->statusCode() !== 0) {
                            $query['composer'] = 1;
                        }
                    }

                    if (!$npm->packagesExists()) {
                        $n_response = $npm->installPackages();

                        if ((int)$n_response->statusCode() !== 0) {
                            $query['npm'] = 1;
                        }
                    }

                    if (count($query) > 0) {
                        $query['installation'] = 'failed';

                        $url = $routes->generate('packages');
                        $url .= '?' . http_build_query($query);

                        \redirect($url);
                    }

                    \redirect($routes->nextViewRouteUrl());
                },
                'packages.setup'
            ]
        ];
    }
}
