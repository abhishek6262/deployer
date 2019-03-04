<?php

if (! function_exists('base_uri')) {
    /**
     * Returns the base uri of the deployer application.
     *
     * @return string
     */
    function base_uri(): string
    {
        return rtrim($_SERVER['SCRIPT_NAME'], '/index.php');
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