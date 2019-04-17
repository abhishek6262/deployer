<?php

namespace Deployer\Recipes;

require_once 'Recipe.php';
require_once 'defaults/InstallProjectPackages/InstallProjectPackagesRecipe.php';
require_once 'defaults/MoveProjectToRoot/MoveProjectToRootRecipe.php';
require_once 'defaults/SetupComposer/SetupComposerRecipe.php';
require_once 'defaults/SetupNodeJS/SetupNodeJSRecipe.php';

use Deployer\Recipes\Defaults\InstallProjectPackages\InstallProjectPackagesRecipe;
use Deployer\Recipes\Defaults\MoveProjectToRoot\MoveProjectToRootRecipe;
use Deployer\Recipes\Defaults\SetupComposer\SetupComposerRecipe;
use Deployer\Recipes\Defaults\SetupNodeJS\SetupNodeJSRecipe;
use Deployer\Routing\RouteCollection;

/**
 * Class RecipeCollection
 * @package Deployer\Recipes
 */
final class RecipeCollection
{
    /**
     * @var array
     */
    private $recipes = [];

    /**
     * @var RouteCollection
     */
    private $routes;

    /**
     * RecipeHandler constructor.
     *
     * @param RouteCollection $routes
     */
    public function __construct(RouteCollection $routes)
    {
        $this->routes = $routes;
        $this->registerRecipes(__RECIPES_DIRECTORY__);
    }

    /**
     * Compare the recipe order to sort them.
     *
     * @param Recipe $recipe_1
     * @param Recipe $recipe_2
     *
     * @return int
     */
    private function compareRecipeOrder(Recipe $recipe_1, Recipe $recipe_2): int
    {
        if ((int)$recipe_1->order === (int)$recipe_2->order) {
            return 0;
        }

        return ((int)$recipe_1->order < (int)$recipe_2->order) ? -1 : 1;
    }

    /**
     * Returns the list of composer packages required by the recipes.
     *
     * @return array
     */
    public function getComposerPackagesList(): array
    {
        $packages = [];

        foreach ($this->recipes() as $recipe) {
            foreach ($recipe->composerPackages as $package) {
                array_push($packages, $package);
            }
        }

        return array_unique($packages);
    }

    /**
     * Returns the list of npm packages required by the recipes.
     *
     * @return array
     */
    public function getNpmPackagesList(): array
    {
        $packages = [];

        foreach ($this->recipes() as $recipe) {
            foreach ($recipe->npmPackages as $package) {
                array_push($packages, $package);
            }
        }

        return array_unique($packages);
    }

    /**
     * Determines whether the recipe is currently working or visible on
     * the screen.
     *
     * @param Recipe $recipe
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
     * @param Recipe $recipe
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
    public function registerDefaults()
    {
        $this->registerRecipe(new SetupComposerRecipe());
        $this->registerRecipe(new SetupNodeJSRecipe());
        $this->registerRecipe(new InstallProjectPackagesRecipe());
        $this->registerRecipe(new MoveProjectToRootRecipe());
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
     * @param Recipe $recipe
     *
     * @return void
     */
    public function registerRecipe(Recipe $recipe)
    {
        array_push($this->recipes, $recipe);

        \uasort($this->recipes, [$this, 'compareRecipeOrder']);
        $this->recipes = array_values($this->recipes);
    }

    /**
     * Register the group of recipes found in the into the application.
     *
     * @param string $path
     *
     * @return void
     */
    public function registerRecipes(string $path)
    {
        foreach (glob($path . '/*') as $dir) {
            $file = $dir . '/' . basename($dir) . 'Recipe.php';

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
