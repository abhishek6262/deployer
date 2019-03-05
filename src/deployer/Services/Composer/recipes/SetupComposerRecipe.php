<?php

namespace Deployer\Services\Composer\Recipes;

use Deployer\Config;
use Deployer\Container\Container;
use Deployer\Recipes\Recipe;
use Deployer\Recipes\RecipeCollection;
use Deployer\Routing\RouteCollection;
use Deployer\View\View;

/**
 * Class SetupComposerRecipe
 * @package Deployer\Services\Composer\Recipes
 */
class SetupComposerRecipe extends Recipe
{
    /**
     * The order on which the recipe will be executed.
     *
     * @var int
     */
    public $order = 0;

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
                function (Container $container, Config $config, RecipeCollection $recipes, RouteCollection $routes)
                {
                    $composer = $container->resolve('composer');

                    if ($composer->exists()) {
                        $url = $routes->generate(
                                    $routes->nextViewRoute()[3]
                                );

                        \redirect($url);
                    }

                    $url = $routes->generate('composer.install');

                    $response =
<<<OUTPUT
                        <h2 class="font-semibold mb-10">Setup Composer</h2>

                        <p class="leading-loose mb-8">
                            Composer is an application-level package manager for the PHP programming language that provides a standard format for managing dependencies of PHP software and required libraries. We can install Composer automatically into the project and get it running instantly.
                        </p>

                        <p class="font-bold leading-loose mb-8">Click on Install button to proceed.</p>

                        <form action="{$url}" method="post">
                            <div class="text-right">
                                <button type="submit" class="bg-indigo hover:bg-indigo-dark font-bold inline-block py-2 px-4 rounded text-white">
                                    Install
                                </button>
                            </div>
                        </form>
OUTPUT;

                    return new View($response);
                },
                'composer'
            ],

            [
                'post',
                '/composer',
                function (Container $container, Config $config, RecipeCollection $recipes, RouteCollection $routes) {
                    $composer = $container->resolve('composer');

                    if (! $composer->exists()) {
                        $composer->install();
                    }

                    $url = $routes->generate(
                                $routes->nextViewRoute()[3]
                            );

                    \redirect($url);
                },
                'composer.install'
            ]
        ];
    }
}