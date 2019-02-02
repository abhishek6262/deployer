<?php

namespace Deployer\Routing;

/**
 * Class RouteCollection
 * @package Deployer\Routing
 */
class RouteCollection
{
    /**
     * @var \AltoRouter
     */
    public $router;

    /**
     * RouteCollection constructor.
     *
     * @param \AltoRouter $router
     */
    public function __construct(\AltoRouter $router)
    {
        $this->router = $router;
    }

    /**
     * Registers a new route in the route collection.
     *
     * @param  string $method
     * @param  string $route
     * @param  $target
     * @param  string|null $name
     *
     * @return void
     *
     * @throws \Exception
     */
    public function add(string $method, string $route, $target, string $name = null): void
    {
        $this->router->map($method, $route, $target, $name);
    }

    /**
     * Registers multiple routes in the route collection.
     *
     * @param  array $routes
     *
     * @return void
     *
     * @throws \Exception
     */
    public function addMultiple(array $routes): void
    {
        if (! empty($routes)) {
            $this->router->addRoutes($routes);
        }
    }

    /**
     * Returns all the routes that are stored in the route collection.
     *
     * @return array
     */
    public function all(): array
    {
        return $this->router->getRoutes();
    }

    /**
     * Returns the matching route with the supplied route name.
     *
     * @param  string $routeName
     * @param  array $params
     *
     * @return string
     *
     * @throws \Exception
     */
    public function generate(string $routeName, array $params = [])
    {
        return $this->router->generate($routeName, $params);
    }

    /**
     * Register the default routes in the routes collection.
     *
     * @return void
     *
     * @throws \Exception
     */
    public function registerDefaults(): void
    {
        $this->addMultiple(
            require_once 'Routes.php'
        );
    }
}