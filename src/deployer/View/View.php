<?php

namespace Deployer\View;

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
     * View constructor.
     *
     * @param  string $response
     */
    public function __construct(string $response)
    {
        $this->response = $response;
    }

    /**
     * Displays footer html.
     *
     * @return void
     */
    public function footer(): void
    {
        require_once '_inc/footer.php';
    }

    /**
     * Generates the view for the supplied response.
     *
     * @return void
     */
    public function generate(): void
    {
        $this->head();

        echo $this->response;

        $this->footer();
    }

    /**
     * Displays head html.
     *
     * @return void
     */
    public function head(): void
    {
        require_once '_inc/header.php';
    }
}