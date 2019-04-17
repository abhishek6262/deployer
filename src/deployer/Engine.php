<?php

namespace Deployer;

use Deployer\Libs\Composer\Composer;
use Deployer\Libs\Node\Node;
use Deployer\Recipes\RecipeCollection;
use Deployer\Routing\RouteCollection;
use Deployer\Routing\Router;

require_once __DEPLOYER_DIRECTORY__ . '/Container.php';
require_once __DEPLOYER_DIRECTORY__ . '/Database.php';
require_once __DEPLOYER_DIRECTORY__ . '/functions.php';
require_once __DEPLOYER_DIRECTORY__ . '/Libs/AltoRouter/AltoRouter.php';
require_once __DEPLOYER_DIRECTORY__ . '/Libs/Composer/Composer.php';
require_once __DEPLOYER_DIRECTORY__ . '/Libs/Node/Node.php';
require_once __DEPLOYER_DIRECTORY__ . '/Recipes/RecipeCollection.php';
require_once __DEPLOYER_DIRECTORY__ . '/Response/Template.php';
require_once __DEPLOYER_DIRECTORY__ . '/Routing/RouteCollection.php';
require_once __DEPLOYER_DIRECTORY__ . '/Routing/Router.php';

/**
 * Class Engine
 * @package Deployer
 */
final class Engine
{
    /**
     * @var Container
     */
    private $container;

    /**
     * @var RecipeCollection
     */
    private $recipes;

    /**
     * @var RouteCollection
     */
    private $routes;

    /**
     * @var string
     */
    const version = 'alpha-0.1';

    /**
     * Engine constructor.
     */
    public function __construct()
    {
        $this->container = new Container();
        $this->routes = new RouteCollection();

        $this->routes->registerDefaults();

        new Composer($this->container);
        new Node($this->container);

        if (Database::hasPreservedConnection()) {
            $this->container->bind('database', Database::regeneratePreservedConnection());
        }

        $this->recipes = new RecipeCollection($this->routes);
        $this->recipes->registerDefaults();
    }

    /**
     * Initializes the deployer application.
     *
     * @return void
     */
    public function start()
    {
        $this->routes->addMultiple(
            $this->recipes->routes()
        );

        $router = new Router($this->routes->all());
        $router->respond($this->container, $this->recipes, $this->routes);
    }
}
