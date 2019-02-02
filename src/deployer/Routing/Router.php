<?php

namespace Deployer\Routing;

require_once __DEPLOYER_DIRECTORY__ . '/Services/AltoRouter/AltoRouter.php';

/**
 * Class Router
 * @package Deployer\Routing
 */
class Router extends \AltoRouter
{
    /**
     * Generates a response for the route.
     *
     * @return void
     */
    public function respond(): void
    {
        $route = $this->match();

        // Call closure or throw 404 status
        if($route && is_callable($route['target'])) {
            call_user_func_array($route['target'], $route['params']); 
        } else {
            // No route was matched
            header($_SERVER["SERVER_PROTOCOL"] . ' 404 Not Found');
        }
    }
}