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
    public $order = 0;

    /**
     * Tasks to perform upon the project.
     *
     * @return void
     */
    public function tasks(): void
    {
        //
    }
}