<?php

namespace Deployer;

require_once __DEPLOYER_DIRECTORY__ . '/Config.php';
require_once __DEPLOYER_DIRECTORY__ . '/Container/Container.php';
require_once __DEPLOYER_DIRECTORY__ . '/Container/ContainerTrait.php';
require_once __DEPLOYER_DIRECTORY__ . '/functions.php';
require_once __DEPLOYER_DIRECTORY__ . '/Project.php';
require_once __DEPLOYER_DIRECTORY__ . '/Recipes/RecipeHandler.php';
require_once __DEPLOYER_DIRECTORY__ . '/Routing/RouteCollection.php';
require_once __DEPLOYER_DIRECTORY__ . '/Routing/Router.php';
require_once __DEPLOYER_DIRECTORY__ . '/Services/Composer/ComposerTrait.php';

use Deployer\Container\ContainerTrait;
use Deployer\Container\Container;
use Deployer\Recipes\RecipeHandler;
use Deployer\Routing\RouteCollection;
use Deployer\Routing\Router;
use Deployer\Services\Composer\ComposerTrait;

/**
 * Class Deployer
 * @package Deployer
 */
class Deployer implements Container
{
    use ComposerTrait, ContainerTrait;

    /**
     * @var Deployer|null
     */
    static $instance = null;

    /**
     * @var float
     */
    const version = 1.0;

    /**
     * Deployer constructor.
     *
     * @throws \Exception
     */
    public function __construct()
    {
        // We'll begin with binding the routes into the service container
        // so we can work on the them from anywhere in the complete
        // application.

        $routes = new RouteCollection(new Router());
        $routes->registerDefaults();

        $this->bind('routes', $routes);

        // Next, we will proceed and register a global configuration
        // handler in the application.

        $this->bind('config', new Config());

        // And finally, we're all set to register the project into the
        // service container. So we can know the details about the project
        // from anywhere in the entire application.

        $project = new Project();
        $project->setPath(__PROJECT_DIRECTORY__);

        $this->bind('project', $project);

        $this->bindComposer();
        $this->bind('recipeHandler', new RecipeHandler());
    }

    /**
     * Gives the deployer a start.
     *
     * @return void
     *
     * @throws \Exception
     */
    public function init()
    {
        $recipeRoutes = $this->resolve('recipeHandler')->getRoutes();

        $routes = $this->resolve('routes');
        $routes->addMultiple($recipeRoutes);

        $router = new Router($routes->all());
        $router->respond();
    }

    /**
     * Returns the instance of the deployer.
     *
     * @return Deployer
     *
     * @throws \Exception
     */
    public static function instance()
    {
        if (is_null(static::$instance)) {
            static::$instance = new static();
        }

        return static::$instance;
    }
}