<?php

if (!function_exists('config')) {
    /**
     * Returns or registers the key and value pair in the deployer
     * configurations container.
     *
     * @param  string $key
     * @param  null $value
     *
     * @return mixed
     *
     * @throws Exception
     */
    function config(string $key, $value = null)
    {
        return container(deployer('config'), $key, $value);
    }
}

if (! function_exists('container')) {
    /**
     * Register or returns the key and value pair in the provided service
     * container.
     *
     * @param  \Deployer\Container\Container $container
     * @param  string $key
     * @param  mixed $value
     *
     * @return mixed
     */
    function container(\Deployer\Container\Container $container, string $key, $value = null)
    {
        if (is_null($value)) {
            return $container->resolve($key);
        }

        $container->bind($key, $value);

        return null;
    }
}

if (! function_exists('deployer')) {
    /**
     * Register or returns the key and value pair in the deployer
     * container.
     *
     * @param  string $key
     * @param  mixed $value
     *
     * @return mixed
     *
     * @throws Exception
     */
    function deployer(string $key, $value = null)
    {
        return container(\Deployer\Deployer::instance(), $key, $value);
    }
}

if (! function_exists('redirect')) {
    /**
     * Redirects the user to the given route.
     *
     * @param string $route
     * @return mixed
     */
    function redirect(string $route)
    {
        header('Location: ' . $route);
        exit;
    }
}