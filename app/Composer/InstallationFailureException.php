<?php

namespace Deployer\Composer;

use Deployer\Exceptions\Contracts\RenderableExceptionInterface;
use Deployer\Exceptions\Exception;

/**
 * Class InstallationFailureException
 * @package Deployer\Composer
 */
class InstallationFailureException extends Exception implements RenderableExceptionInterface
{
    /**
     * @var string
     */
    protected $download_link = "https://getcomposer.org/";

    /**
     * Displays the view for the failed installation of Composer.
     *
     * @return void
     */
    public function render()
    {
        echo $this->getMessage() . " <a href='$this->download_link'>Click Here</a> To Download Manually.";
    }
}