<?php

namespace Deployer\Recipes;

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
     * The routes that recipe will operate upon.
     * 
     * @var array
     */
    public $routes = [];

    /**
     * Tasks to perform upon the project.
     *
     * @return void
     */
    abstract public function tasks(): void;

    /**
     * The list of configuration to prepare view for the recipe.
     *
     * @return array|null
     */
    public function view(): ?array
    {
        return null;
    }
}