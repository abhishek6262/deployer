<?php

namespace Deployer\Recipes;

require_once 'Recipe.php';
require_once 'defaults/InstallPackagesRecipe.php';
require_once 'defaults/FinishRecipe.php';

use Deployer\Recipes\Defaults\InstallPackagesRecipe;
use Deployer\Recipes\Defaults\FinishRecipe;
use Deployer\Routing\RouteCollection;

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
     * @var RouteCollection
     */
    protected $routes;

    /**
     * RecipeHandler constructor.
     * 
     * @param  RouteCollection $routes
     */
    public function __construct(RouteCollection $routes)
    {
        $this->routes = $routes;
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
     * Determines whether the recipe is currently working or visible on
     * the screen.
     * 
     * @param  Recipe $recipe
     * 
     * @return bool
     */
    public function isRecipeActive(Recipe $recipe): bool
    {
        $current = $this->routes->router->match();

        foreach ($recipe->routes() as $route) {
            if ($route[0] === 'GET' && $current['name'] === $route[3]) {
                return true;
            }
        }

        return false;
    }

    /**
     * Determines whether the recipe has completed its work.
     * 
     * @param  Recipe $recipe
     * 
     * @return bool
     */
    public function isRecipeCompleted(Recipe $recipe): bool
    {
        // Fetch index of active recipe.
        $active_recipe_index = -1;
        $current = $this->routes->router->match();

        foreach ($this->recipes as $key => $_recipe) {
            if ($active_recipe_index !== -1) {
                break;
            }

            foreach ($_recipe->routes() as $route) {
                if ($route[0] === 'GET' && $current['name'] === $route[3]) {
                    $active_recipe_index = $key;
                    break;
                }
            }
        }

        // Fetch index of supplied recipe.
        $recipe_index = 0;

        foreach ($this->recipes as $key => $_recipe) {
            if (get_class($recipe) === get_class($_recipe)) {
                $recipe_index = $key;
                break;
            }
        }

        return $active_recipe_index > $recipe_index;
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
     * Register the default recipes into the application.
     * 
     * @return void
     */
    public function registerDefaults(): void
    {
        $this->registerRecipe(new InstallPackagesRecipe());
        $this->registerRecipe(new FinishRecipe());
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
        $this->recipes = array_values($this->recipes);
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