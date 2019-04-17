<?php

namespace Deployer\Routing;

/**
 * Class RouteCollection
 * @package Deployer\Routing
 */
final class RouteCollection
{
    /**
     * @var \AltoRouter
     */
    public $router;

    /**
     * RouteCollection constructor.
     *
     * @throws \Exception
     */
    public function __construct()
    {
        $this->router = new \AltoRouter();
    }

    /**
     * Registers a new route in the route collection.
     *
     * @param string $method
     * @param string $route
     * @param  $target
     * @param string $name
     *
     * @return void
     *
     * @throws \Exception
     */
    public function add(string $method, string $route, $target, string $name)
    {
        $this->router->map(
            $method,
            $this->makeValidRoute($route),
            $target,
            $name
        );
    }

    /**
     * Registers multiple routes in the route collection.
     *
     * @param array $routes
     *
     * @return void
     *
     * @throws \Exception
     */
    public function addMultiple(array $routes)
    {
        foreach ($routes as $route) {
            call_user_func_array([$this, 'add'], $route);
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
     * @param string $routeName
     * @param array $params
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
     * Determines whether the route is viewable.
     *
     * @param array $route
     *
     * @return bool
     */
    public function isViewRoute(array $route): bool
    {
        if ($route[0] !== 'GET') {
            return false;
        } elseif ($route['3'] === 'page-not-found') {
            return false;
        }

        return true;
    }

    /**
     * Register the default routes in the routes collection.
     *
     * @return void
     *
     * @throws \Exception
     */
    public function registerDefaults()
    {
        $this->addMultiple(
            require_once 'Routes.php'
        );
    }

    /**
     * Returns the valid url from the supplied route.
     *
     * @param string $route
     *
     * @return string
     */
    protected function makeValidRoute(string $route): string
    {
        $host = parse_url($route, PHP_URL_HOST);

        if (empty($host)) {
            // Localhost routes often follow the pattern like:
            // "http://localhost/deployer", which makes the routes fail to
            // load on it because the router only checks for URI and
            // "/deployer" path does not exist on them. Hence, we need
            // to automatically add that path in the routes supplied by
            // the services or the application to make them load fine on
            // domain as well as localhost.

            $route = base_uri() . '/' . ltrim($route, '/');
        }

        return $route;
    }

    /**
     * Returns the first view route.
     *
     * @param array $routes
     *
     * @return array|null
     */
    public function firstViewRoute(array $routes = []): ?array
    {
        $routes = empty($routes) ? $this->all() : $routes;

        foreach ($routes as $route) {
            if ($this->isViewRoute($route)) {
                return $route;
            }
        }

        return null;
    }

    /**
     * Returns the next view route.
     *
     * @param array $routes
     *
     * @return array|null
     */
    public function nextViewRoute(array $routes = []): ?array
    {
        $routes = empty($routes) ? $this->all() : $routes;
        $current = $this->router->match();

        // We'll have to check for the view route next from the current
        // view route. Therefore, we'll check for the position of the
        // current view route in the collection and then return next view
        // route.
        $found = false;

        foreach ($routes as $route) {
            if ($route[3] === $current['name']) {
                $found = true;
                continue;
            }

            if ($found && $this->isViewRoute($route)) {
                return $route;
            }
        }

        return null;
    }

    /**
     * Returns the url for the next view route.
     *
     * @param array $routes
     *
     * @return string|null
     *
     * @throws \Exception
     */
    public function nextViewRouteUrl(array $routes = []): ?string
    {
        $route = $this->nextViewRoute($routes);

        if (empty($route)) {
            return null;
        }

        return $this->generate($route[3]);
    }
}