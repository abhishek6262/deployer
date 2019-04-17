<?php

namespace Deployer\Recipes\Defaults\SetupComposer;

use abhishek6262\Composer\Composer;
use Deployer\Container;
use Deployer\Recipes\Recipe;
use Deployer\Recipes\RecipeCollection;
use Deployer\Response\Template;
use Deployer\Response\View;
use Deployer\Routing\RouteCollection;

/**
 * Class SetupComposerRecipe
 * @package Deployer\Recipes\Defaults\SetupComposer
 */
class SetupComposerRecipe extends Recipe
{
    /**
     * The order on which the recipe will be executed.
     *
     * @var int
     */
    public $order = 100;

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
                '/composer',
                function (RouteCollection $routes, Container $container, RecipeCollection $recipes) {
                    $composer = $container->resolve('composer');

                    if ($composer->exists() && count($recipes->getComposerPackagesList()) < 1) {
                        \redirect($routes->nextViewRouteUrl());
                    }

                    $response = new Template(
                        __DIR__ . '/SetupComposerIntro.php',
                        [
                            'routes' => $routes
                        ]
                    );

                    return new View($response);
                },
                'composer'
            ],

            [
                'POST',
                '/composer',
                function (RouteCollection $routes, Container $container, RecipeCollection $recipes) {
                    $composer = new Composer(__ROOT_DIRECTORY__, __BIN_DIRECTORY__);

                    if (!$composer->exists()) {
                        $composer->install();
                    }

                    $composer->installPackages();

                    if (count($composer_packages = $recipes->getComposerPackagesList()) > 0) {
                        $composer->rawCommand('require ' . implode(' ', $composer_packages));
                    }

                    \redirect($routes->nextViewRouteUrl());
                },
                'composer.setup'
            ]
        ];
    }
}
