<?php

namespace Deployer\Routing;

require_once __DEPLOYER_DIRECTORY__ . '/Services/AltoRouter/AltoRouter.php';

use Deployer\Config;
use Deployer\Container\Container;
use Deployer\Recipes\RecipeCollection;
use Deployer\View\View;

/**
 * Class Router
 * @package Deployer\Routing
 */
class Router extends \AltoRouter
{
    /**
     * Generates a response for the route.
     *
     * @param  Container $container
     * @param  Config $config
     * @param  RecipeCollection $recipes
     * @param  RouteCollection $routes
     * 
     * @return void
     *
     * @throws \Exception
     */
    public function respond(Container $container, Config $config, RecipeCollection $recipes, RouteCollection $routes): void
    {
        $route = $this->match();

        // Call closure or throw 404 status
        if($route && is_callable($route['target'])) {
            $properties[] = $container;
            $properties[] = $config;
            $properties[] = $recipes;
            $properties[] = $routes;
            $properties[] = $route['params'];

            $response = call_user_func_array($route['target'], $properties);

            echo $response instanceof View
                    ? $response->generate($recipes)
                    : $response;
        } else {
            // No route was matched
            redirect(
                $this->generate('page-not-found')
            );
        }
    }
}