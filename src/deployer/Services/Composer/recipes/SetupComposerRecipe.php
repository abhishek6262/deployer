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
                    $response =
<<<OUTPUT
                        <h2 class="font-semibold" style="font-family: 'Open Sans';">Setup Composer</h2>
OUTPUT;

                    return new View($response);
                },
                'composer'
            ],

            [
                'post',
                '/composer',
                function () {
                    // 
                },
                'composer.install'
            ]
        ];
    }
}