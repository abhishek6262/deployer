<?php

namespace Deployer;

/**
 * Class Recipe
 * @package Deployer
 */
class Recipe
{
    /**
     * @var array
     */
    private $recipe;

    /**
     * Recipe constructor.
     *
     * @param array $recipe
     */
    public function __construct(array $recipe)
    {
        $this->recipe = $recipe;
    }

    /**
     * Deploys the application based on the supplied recipe instructions.
     *
     * @return void
     */
    public function bake(): void
    {
        foreach ($this->recipe as $instruction) {
            $callable = $instruction;
            $args     = [];

            if (! is_callable($instruction) && (is_array($instruction) && count($instruction) > 1)) {
                $callable = $instruction[0];
                $args	  = $instruction[1];
            }

            if (is_callable($callable)) {
                call_user_func_array($callable, $args);
            }
        }
    }
}