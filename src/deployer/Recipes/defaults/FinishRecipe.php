<?php

namespace Deployer\Recipes\Defaults;

use Deployer\Config;
use Deployer\Container\Container;
use Deployer\Recipes\Recipe;
use Deployer\Recipes\RecipeCollection;
use Deployer\Routing\RouteCollection;
use Deployer\View\View;

/**
 * Class FinishRecipe
 * @package Deployer\Recipes\Defaults
 */
class FinishRecipe extends Recipe
{
    /**
     * The order on which the recipe will be executed.
     *
     * @var int
     */
    public $order = 99999;

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
                '/finish',
                function (Container $container, Config $config, RecipeCollection $recipes, RouteCollection $routes) {
                    // 
                },
                'finish'
            ]
        ];
    }
}