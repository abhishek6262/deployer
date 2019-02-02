<?php

namespace Deployer\Recipes;

require_once 'Recipe.php';

/**
 * Class RecipeHandler
 * @package Deployer\Recipes
 */
class RecipeHandler
{
    /**
     * @var array
     */
    public $recipes = [];

    /**
     * RecipeHandler constructor.
     */
    public function __construct()
    {
        $this->bootRecipes();
    }

    /**
     * Boots the recipes into the recipe handler.
     * 
     * @return void
     */
    public function bootRecipes(): void
    {
        foreach (glob(__RECIPES_DIRECTORY__ . '/*.php') as $file)
        {
            /** @noinspection PhpIncludeInspection */
            require_once $file;

            // Get the file name of the current file without the extension
            // which is essentially the class name.
            $recipe = basename($file, '.php');

            if (class_exists($recipe) && \is_subclass_of($recipe, Recipe::class)) {
                array_push($this->recipes, new $recipe);
            }
        }

        \uasort($this->recipes, [$this, 'compareRecipeOrder']);
    }

    /**
     * Compare the recipe order to sort them.
     *
     * @param  Recipe $recipe_1
     * @param  Recipe $recipe_2
     *
     * @return int
     */
    public function compareRecipeOrder(Recipe $recipe_1, Recipe $recipe_2): int
    {
        if ((int) $recipe_1->order === (int) $recipe_2->order) {
            return 0;
        }

        return ((int) $recipe_1->order < (int) $recipe_2->order) ? -1 : 1;
    }

    /**
     * Returns the list of recipes available in the application.
     * 
     * @return array
     */
    public function getRecipes(): array
    {
        return $this->recipes;
    }

    /**
     * Returns the routes declared in the recipes.
     *
     * @return array
     */
    public function getRoutes(): array
    {
        $routes = [];

        foreach ($this->recipes as $recipe) {
            if (empty($recipe->routes)) {
                continue;
            }

            foreach ($recipe->routes as $route) {
                if (empty($route)) {
                    continue;
                }

                array_push($routes, $route);
            }
        }

        return $routes;
    }
}