<?php

namespace Deployer\Response;

/**
 * Class View
 * @package Deployer\Response
 */
class View
{
    /**
     * @var string
     */
    private $response;

    /**
     * @var bool
     */
    private $show_blank;

    /**
     * View constructor.
     *
     * @param $response
     * @param bool $show_blank
     */
    public function __construct($response, bool $show_blank = false)
    {
        $this->response = $response instanceof Template ? $response->content() : $response;
        $this->show_blank = $show_blank;
    }

    /**
     * Generates the view for the supplied response.
     *
     * @param  $collection
     *
     * @return void
     */
    public function generate($collection)
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
