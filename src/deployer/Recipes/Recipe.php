<?php

namespace Deployer\Recipes;

/**
 * Class Recipe
 * @package Deployer\Recipes
 */
abstract class Recipe
{
    /**
     * The list of composer packages required for the recipe.
     * 
     * @var array
     */
    public $composerPackages = [];

    /**
     * The list of npm packages required for the recipe.
     *
     * @var array
     */
    public $npmPackages = [];

    /**
     * The name for the recipe.
     * 
     * @var string|null
     */
    public $name = null;

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