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

if (! function_exists('normalize_pascal_case')) {
    /**
     * Returns the normalized version of the Pascal Case string.
     * 
     * @param  string $input
     * 
     * @return string
     */
    function normalize_pascal_case(string $input): string
    {
        preg_match_all('!([A-Z][A-Z0-9]*(?=$|[A-Z][a-z0-9])|[A-Za-z][a-z0-9]+)!', $input, $matches);

        $ret = $matches[0];

        foreach ($ret as &$match) {
            $match = $match == strtoupper($match) ? strtolower($match) : lcfirst($match);
        }

        $words = implode(' ', $ret);

        return ucwords($words);
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