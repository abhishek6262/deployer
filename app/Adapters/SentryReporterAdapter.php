<?php

namespace Deployer\Adapters;

use Deployer\Contracts\ReporterInterface;
use Deployer\Exceptions\Exception;

/**
 * Class SentryReporterAdapter
 * @package Deployer\Adapters
 */
class SentryReporterAdapter implements ReporterInterface
{
    /**
     * @var \Raven_Client
     */
    private $client;

    /**
     * SentryReporterAdapter constructor.
     *
     * @param \Raven_Client $client
     */
    public function __construct(\Raven_Client $client)
    {
        $this->client = $client;
    }

    /**
     * Reports the exception passed to the Sentry's server.
     *
     * @param  $exception
     *
     * @return void
     */
    public function report($exception): void
    {
        $this->client->captureException($exception);
    }
}