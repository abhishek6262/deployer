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
    private $instructions;

    /**
     * Recipe constructor.
     *
     * @param array $recipes
     */
    public function __construct(array $recipes)
    {
        $this->instructions = $recipes;
    }

    /**
     * Deploys the application based on the supplied instructions.
     *
     * @return void
     */
    public function bake(): void
    {
        foreach ($this->instructions as $instruction) {
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