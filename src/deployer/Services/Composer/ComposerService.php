<?php

namespace Deployer\Services\Composer;

require_once 'SetupComposerRecipe.php';
require_once 'Composer/Composer.php';

use abhishek6262\Composer\Composer;
use Deployer\Container\Container;
use Deployer\Recipes\RecipeCollection;
use Deployer\Services\Composer\SetupComposerRecipe;

/**
 * Class ComposerService
 * @package Deployer\Services\Composer
 */
class ComposerService
{
    /**
     * ComposerService constructor.
     *
     * @param  Container $container
     * @param  RecipeCollection $recipes
     */
    public function __construct(Container $container, RecipeCollection $recipes)
    {
        $container->bind('composer', new Composer(__PROJECT_DIRECTORY__, __BIN_DIRECTORY__));
        $recipes->registerRecipe(new SetupComposerRecipe());
    }
}