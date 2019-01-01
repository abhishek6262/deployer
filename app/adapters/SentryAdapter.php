<?php

namespace App\Adapters;

use App\Contracts\ExceptionHandlerInterface;

/**
 * Class SentryAdapter
 * @package App\Adapters
 */
class SentryAdapter implements ExceptionHandlerInterface {
    /**
     * @var \Raven_Client
     */
    protected $client;

    /**
     * SentryAdapter constructor.
     *
     * @param \Raven_Client $client
     */
    public function __construct(\Raven_Client $client) {
        $this->client = $client;
    }

    /**
     * Reports the exceptions thrown or errors occurred in the application
     * to the Sentry servers.
     *
     * @return void
     */
    public function report() {
        try {
            $this->client->install();
        } catch (\Exception $ex) {
            // 
        }
    }
}