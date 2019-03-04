<?php

namespace Deployer\Recipes;

require_once 'Recipe.php';

/**
 * Class RecipeCollection
 * @package Deployer\Recipes
 */
class RecipeCollection
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
        $this->registerRecipes(__RECIPES_DIRECTORY__);
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
    public function recipes(): array
    {
        return $this->recipes;
    }

    /**
     * Returns the routes declared in the recipes.
     *
     * @return array
     */
    public function routes(): array
    {
        $routes = [];

        foreach ($this->recipes as $recipe) {
            $_routes = $recipe->routes();

            if (empty($_routes)) {
                continue;
            }

            foreach ($_routes as $route) {
                if (empty($route)) {
                    continue;
                }

                array_push($routes, $route);
            }
        }

        return $routes;
    }

    /**
     * Register the supplied instance of recipe into the application.
     * 
     * @param  Recipe $recipe
     * 
     * @return void
     */
    public function registerRecipe(Recipe $recipe): void
    {
        array_push($this->recipes, $recipe);

        \uasort($this->recipes, [$this, 'compareRecipeOrder']);
    }

    /**
     * Register the group of recipes found in the into the application.
     *
     * @param  string $path
     *
     * @return void
     */
    public function registerRecipes(string $path): void
    {
        foreach (glob($path . '/*.php') as $file)
        {
            /** @noinspection PhpIncludeInspection */
            require_once $file;

            // Get the file name of the current file without the extension
            // which is essentially the class name.
            $recipe = basename($file, '.php');

            if (class_exists($recipe) && \is_subclass_of($recipe, Recipe::class)) {
                $this->registerRecipe(new $recipe);
            }
        }
    }
}