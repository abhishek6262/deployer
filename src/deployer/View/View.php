<?php

namespace Deployer\View;

use Deployer\Recipes\RecipeCollection;
use Deployer\Routing\RouteCollection;

/**
 * Class View
 * @package Deployer\View
 */
class View
{
    /**
     * @var string
     */
    protected $response;

    /**
     * @var bool
     */
    protected $show_blank;

    /**
     * View constructor.
     *
     * @param  string $response
     * @param  bool $show_blank
     */
    public function __construct(string $response, bool $show_blank = false)
    {
        $this->response   = $response;
        $this->show_blank = $show_blank;
    }

    /**
     * Generates the view for the supplied response.
     *
     * @param  RecipeCollection $collection
     * 
     * @return void
     */
    public function generate(RecipeCollection $collection): void
    {
        require_once '_inc/header.php';

        if ($this->show_blank) {
            require_once '_inc/blank-container.php';
        } else {
            require_once '_inc/recipes-container.php';
        }

        require_once '_inc/footer.php';
    }
}