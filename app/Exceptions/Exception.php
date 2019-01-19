<?php

namespace Deployer\Exceptions;

use Deployer\Contracts\ReporterInterface;

/**
 * Class Exception
 * @package Deployer\Exceptions
 */
class Exception extends \Exception
{
    /**
     * @var ReporterInterface
     */
    private $reporter;

    /**
     * Generates a nice looking template for the thrown exception.
     *
     * @return void
     */
    public function render()
    {
        //
    }

    /**
     * Reports the exception thrown to the third-party or by logging it
     * into the file.
     *
     * @return void
     */
    public function report(): void
    {
        $this->reporter->report($this);
    }

    /**
     * Set the reporter to log the exception thrown in the application.
     *
     * @param  ReporterInterface $reporter
     *
     * @return $this
     */
    public function setReporter(ReporterInterface $reporter): self
    {
        $this->reporter = $reporter;

        return $this;
    }
}