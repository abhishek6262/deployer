<?php

use Deployer\Response\Template;
use Deployer\Response\View;
use Deployer\Routing\RouteCollection;

return [
    [
        'GET',
        '/',
        function (RouteCollection $routes) {
            $response = new Template(
                __DEPLOYER_DIRECTORY__ . '/Response/templates/home.php',
                [
                    'routes' => $routes
                ]
            );

            return new View($response, true);
        },
        'home'
    ],

    [
        'GET',
        '/recipes/intro',
        function (RouteCollection $routes) {
            $response = new Template(
                __DEPLOYER_DIRECTORY__ . '/Response/templates/recipes.php',
                [
                    'routes' => $routes
                ]
            );

            return new View($response, true);
        },
        'recipes.intro'
    ],

    [
        'GET',
        '/404',
        function () {
            header($_SERVER["SERVER_PROTOCOL"] . ' 404 Not Found');

            echo "Sorry! Page not found.";
        },
        'page-not-found'
    ]
];
