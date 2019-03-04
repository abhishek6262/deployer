<?php

namespace Deployer\Recipes;

use Deployer\Routing\RouteCollection;

/**
 * Class Recipe
 * @package Deployer\Recipes
 */
abstract class Recipe
{
    /**
     * The order on which the recipe will be executed.
     *
     * @var int
     */
    public $order = 5000;

    /**
     * The list of routes for the recipe.
     *
     * @return array
     */
    abstract public function routes(): array;
}