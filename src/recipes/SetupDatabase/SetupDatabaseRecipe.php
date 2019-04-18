<?php

use Deployer\Recipes\Recipe;
use Deployer\Response\View;
use Deployer\Routing\RouteCollection;

/**
 * Class SetupDatabaseRecipe
 */
class SetupDatabaseRecipe extends Recipe
{
    /**
     * The order on which the recipe will be executed.
     *
     * @var int
     */
    public $order = 5000;

    /**
     * The list of routes for the recipe.
     *
     * @return array
     */
    public function routes(): array
    {
        return [
            [
                'GET',
                'database',
                function (RouteCollection $routes) {
                    $error = '';

                    if (isset($_GET['fields']) && $_GET['fields'] === 'empty') {
                        $error = 'All fields are required to make a database connection.';
                    } elseif (isset($_GET['connection']) && $_GET['connection'] === 'failed') {
                        $error = 'Invalid details. Failed to connect to the database.';
                    } elseif (isset($_GET['import']) && $_GET['import'] === 'failed') {
                        $error = 'Failed to import the database.';
                    } 

                    $response = new \Deployer\Response\Template(
                        __DIR__ . '/SetupDatabaseForm.php',
                        [
                            'error'  => $error,
                            'routes' => $routes
                        ]
                    );

                    return new View($response);
                },
                'database'
            ],

            [
                'POST',
                'database',
                [
                    $this,
                    'setupDatabase'
                ],
                'database.setup'
            ],
        ];
    }

    /**
     * Setup the database by performing necessary steps on it.
     *
     * @param RouteCollection $routes
     *
     * @return void
     *
     * @throws Exception
     */
    public function setupDatabase(RouteCollection $routes)
    {
        $DB_NAME = filter_var(trim($_POST['name']), FILTER_SANITIZE_STRING);
        $DB_HOST = filter_var(trim($_POST['host'], FILTER_SANITIZE_STRING));
        $DB_PORT = filter_var(trim($_POST['port']), FILTER_SANITIZE_NUMBER_INT);
        $DB_USER = filter_var(trim($_POST['user']), FILTER_SANITIZE_STRING);
        $DB_PASS = trim($_POST['pass']);

        if (empty($DB_NAME) || empty($DB_HOST) || empty($DB_PORT) || empty($DB_USER)) {
            $url = $routes->generate('database');
            $url .= '?' . http_build_query(['fields' => 'empty']);

            \redirect($url);
        }

        $DB = new \Deployer\Database(
            $DB_NAME,
            $DB_USER,
            $DB_PASS,
            $DB_HOST,
            $DB_PORT
        );

        try {
            $DB->connection();
        } catch (\PDOException $e) {
            $url = $routes->generate('database');
            $url .= '?' . http_build_query(['connection' => 'failed']);

            \redirect($url);
        }

        if (file_exists($file = __PROJECT_DIRECTORY__ . '/database.sql')) {
            if (!$DB->importSqlFile($file)) {
                $url = $routes->generate('database.setup');
                $url .= '?' . http_build_query(['import' => 'failed']);

                redirect($url);
            }
        }

        \redirect($routes->nextViewRouteUrl());
    }
}
