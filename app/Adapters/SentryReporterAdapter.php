<?php

namespace App\Adapters;

use App\Contracts\ReporterInterface;
use App\Exceptions\Exception;

/**
 * Class SentryReporterAdapter
 * @package App\Adapters
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
     * @param Exception $exception
     *
     * @return void
     */
    public function report(Exception $exception): void
    {
        $this->client->captureException($exception);
    }
}