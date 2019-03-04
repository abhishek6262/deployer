<?php

namespace Deployer\Services\Composer;

use Deployer\Config;
use Deployer\Container\Container;
use Deployer\Recipes\Recipe;
use Deployer\Recipes\RecipeCollection;
use Deployer\Routing\RouteCollection;
use Deployer\View\View;

/**
 * Class ComposerRecipe
 * @package Deployer\Services\Composer
 */
class ComposerRecipe extends Recipe
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
                    return new View('Hello from composer.');
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