<?php

use Deployer\Config;
use Deployer\Container\Container;
use Deployer\Recipes\RecipeCollection;
use Deployer\Routing\RouteCollection;

return [
    [
        'GET',
        '/',
        function (Container $container, Config $config, RecipeCollection $recipes, RouteCollection $routes, $params)
        {
            $route = $routes->nextViewRoute();
            $url   = $routes->generate($route[3]);

            $response =
<<<OUTPUT
                <div class="flex items-center h-screen">
                    <div class="mx-auto">
                        <div class="bg-white max-w-xs overflow-hidden p-8 rounded shadow-sm">
                            <div class="mb-5">
                                <div class="bg-indigo-lighter font-bold rounded-full h-16 w-16 flex items-center justify-center mb-6">
                                    D
                                </div>

                                <div class="font-bold text-xl mb-4" style="font-family: 'Lato';">Welcome To Deployer.</div>

                                <p class="leading-loose text-base text-grey-darker" style="font-family: 'Open Sans';">
                                    An easy-to-use installation wizard for the next-gen web application.
                                </p>
                            </div>

                            <div>
                                <a href="{$url}" class="bg-indigo hover:bg-indigo-dark font-bold inline-block py-2 px-4 rounded text-white" style="font-family: 'Open Sans';">
                                    Get started
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
OUTPUT;

            return new Deployer\View\View($response, true);
        },
        'home'
    ],

    [
        'GET',
        '/recipes/intro',
        function (Container $container, Config $config, RecipeCollection $recipes, RouteCollection $routes)
        {
            $route = $routes->nextViewRoute();
            $url   = $routes->generate($route[3]);

            $response =
<<<OUTPUT
                <div class="flex items-center h-screen">
                    <div class="mx-auto">
                        <div class="bg-white max-w-xs overflow-hidden p-8 rounded shadow-sm">
                            <div class="mb-5">
                                <div class="bg-indigo-lighter font-bold rounded-full h-16 w-16 flex items-center justify-center mb-6">
                                    R
                                </div>

                                <div class="font-bold text-xl mb-4" style="font-family: 'Lato';">Recipes.</div>

                                <p class="leading-loose text-base text-grey-darker" style="font-family: 'Open Sans';">
                                    Recipes make up the Deployer and helps you to setup the application.
                                </p>

                                <p class="font-bold leading-loose text-base text-grey-darker mt-4" style="font-family: 'Open Sans';">
                                    Click on proceed to continue.
                                </p>
                            </div>

                            <div>
                                <a href="{$url}" class="bg-indigo hover:bg-indigo-dark font-bold inline-block py-2 px-4 rounded text-white" style="font-family: 'Open Sans';">
                                    Proceed
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
OUTPUT;

            return new Deployer\View\View($response, true);
        },
        'intro-recipes'
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