<?php

namespace Deployer\NPM;

use Deployer\Exceptions\Contracts\RenderableExceptionInterface;
use Deployer\Exceptions\Contracts\ReportableExceptionInterface;
use Deployer\Exceptions\Exception;

/**
 * Class InstallationFailureException
 * @package Deployer\NPM
 */
class InstallationFailureException extends Exception implements RenderableExceptionInterface, ReportableExceptionInterface
{
    /**
     * @var string
     */
    protected $download_link = "https://nodejs.org/en/";

    /**
     * Displays the view for the failed installation of NPM.
     *
     * @return void
     */
    public function render()
    {
        echo $this->getMessage() . " <a href='$this->download_link' target='_blank'>Click Here</a> To Download Manually.";
    }
}