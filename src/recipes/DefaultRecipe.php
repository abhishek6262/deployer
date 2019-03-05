<?php

use Deployer\Recipes\Recipe;

/**
 * Class DefaultRecipe
 */
class DefaultRecipe extends Recipe
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
    public function routes(): array
    {
        return [
            //
        ];
    }
}