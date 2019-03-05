<?php

namespace Deployer;

require_once __DEPLOYER_DIRECTORY__ . '/functions.php';
require_once __DEPLOYER_DIRECTORY__ . '/Config.php';
require_once __DEPLOYER_DIRECTORY__ . '/Container/Container.php';
require_once __DEPLOYER_DIRECTORY__ . '/Container/ContainerTrait.php';
require_once __DEPLOYER_DIRECTORY__ . '/Project.php';
require_once __DEPLOYER_DIRECTORY__ . '/Recipes/Recipe.php';
require_once __DEPLOYER_DIRECTORY__ . '/Recipes/RecipeCollection.php';
require_once __DEPLOYER_DIRECTORY__ . '/Routing/RouteCollection.php';
require_once __DEPLOYER_DIRECTORY__ . '/Routing/Router.php';
require_once __DEPLOYER_DIRECTORY__ . '/Services/Composer/ComposerService.php';
require_once __DEPLOYER_DIRECTORY__ . '/Services/Node/NodeService.php';
require_once __DEPLOYER_DIRECTORY__ . '/View/View.php';

use Deployer\Container\Container;
use Deployer\Container\ContainerTrait;
use Deployer\Recipes\RecipeCollection;
use Deployer\Routing\RouteCollection;
use Deployer\Routing\Router;
use Deployer\Services\Composer\ComposerService;
use Deployer\Services\Node\NodeService;

/**
 * Class Deployer
 * @package Deployer
 */
class Deployer implements Container
{
    use ContainerTrait;

    /**
     * @var \Deployer\Config
     */
    protected $config;

    /**
     * @var RecipeCollection
     */
    protected $recipes;

    /**
     * @var RouteCollection
     */
    protected $routes;

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
        if (file_exists($autoload = __ROOT_DIRECTORY__ . '/vendor/autoload.php')) {
            /** @noinspection PhpIncludeInspection */
            require_once $autoload;
        }

        $this->config = new Config();

        $project = new Project();
        $project->setPath(__PROJECT_DIRECTORY__);

        $this->bind('project', $project);

        $this->routes = new RouteCollection();
        $this->routes->registerDefaults();

        $this->recipes = new RecipeCollection($this->routes);
        $this->recipes->registerDefaults();

        new ComposerService($this, $this->recipes);
        new NodeService($this, $this->recipes);
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
        $recipeRoutes = $this->recipes->routes();
        $this->routes->addMultiple($recipeRoutes);

        $router = new Router($this->routes->all());
        $router->respond($this, $this->config, $this->recipes, $this->routes);
    }
}