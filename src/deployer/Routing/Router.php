<?php

namespace Deployer\Routing;

use Deployer\Container;
use Deployer\Recipes\RecipeCollection;
use Deployer\Response\View;

require_once __DEPLOYER_DIRECTORY__ . '/Response/View.php';

/**
 * Class Router
 * @package Deployer\Routing
 */
class Router extends \AltoRouter
{
    /**
     * Generates a response for the route.
     *
     * @param Container $container
     * @param RecipeCollection $recipes
     * @param RouteCollection $routes
     *
     * @return void
     *
     * @throws \Exception
     */
    public function respond(Container $container, RecipeCollection $recipes, RouteCollection $routes)
    {
        $route = $this->match();

        // Call closure or throw 404 status
        if ($route && is_callable($route['target'])) {
            $params[] = $routes;
            $params[] = $container;
            $params[] = $recipes;

            $response = call_user_func_array($route['target'], $params);

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
