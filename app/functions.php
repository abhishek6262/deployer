<?php

namespace App;

if (!function_exists("config")) {
    /**
     * Returns the configuration data for the application.
     *
     * @param  string $key
     *
     * @return string|null
     */
    function config($key)
    {
        $str = file_get_contents(__DIR__ . '/../config.json');
        $data = json_decode($str, true);

        return array_key_exists($key, $data) ? $data[$key] : null;
    }
}