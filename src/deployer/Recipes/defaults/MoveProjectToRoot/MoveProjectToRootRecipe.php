<?php

namespace Deployer\Recipes\Defaults\MoveProjectToRoot;

use Deployer\Recipes\Recipe;
use Deployer\Response\Template;
use Deployer\Response\View;
use Deployer\Routing\RouteCollection;

/**
 * Class MoveProjectToRootRecipe
 * @package Deployer\Recipes\Defaults\MoveProjectToRoot
 */
class MoveProjectToRootRecipe extends Recipe
{
    /**
     * The name for the recipe.
     *
     * @var string|null
     */
    public $name = 'Finish';

    /**
     * The order on which the recipe will be executed.
     *
     * @var int
     */
    public $order = 99999;

    /**
     * @var string
     */
    private $backupPath = __ROOT_DIRECTORY__ . '/.deployer';

    /**
     * The list of files and directories to exclude while restoring the
     * application.
     *
     * @var array
     */
    private $exclude = [
        __ROOT_DIRECTORY__ . '/.deployer',
    ];

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
                '/finish',
                function (RouteCollection $routes) {
                    $response = new Template(
                        __DIR__ . '/Finish.php',
                        [
                            'routes' => $routes
                        ]
                    );

                    return new View($response, true);
                },
                'finish'
            ],

            [
                'POST',
                '/finish',
                function () {
                    $this->backupDeployerFiles();
                    $this->moveProjectFilesToRoot();

                    redirect(base_uri());
                },
                'finish.setup'
            ]
        ];
    }

    /**
     * Makes a backup of the deployer files in case it is needed in the
     * future for the same project.
     *
     * @return void
     */
    private function backupDeployerFiles()
    {
        if (!file_exists($this->backupPath)) {
            mkdir($this->backupPath, 0777);
        }

        $excludes = $this->exclude;

        array_push(
            $excludes,
            __ROOT_DIRECTORY__ . '/vendor'
        );

        r_copy(__ROOT_DIRECTORY__, $this->backupPath, $excludes);
        r_rmdir(__ROOT_DIRECTORY__, $this->exclude);
    }

    /**
     * Moves project files to root.
     *
     * @return void
     */
    private function moveProjectFilesToRoot()
    {
        r_copy($this->backupPath . '/src', __ROOT_DIRECTORY__);
    }
}
