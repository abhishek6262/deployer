<?php

namespace App\Composer;

use App\Exceptions\Contracts\RenderableExceptionInterface;
use App\Exceptions\Exception;

/**
 * Class InstallationFailureException
 * @package App\Composer
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