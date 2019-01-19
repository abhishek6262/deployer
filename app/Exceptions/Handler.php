<?php

namespace Deployer\Exceptions;

use Deployer\Adapters\SentryReporterAdapter;
use Deployer\Contracts\ReporterInterface;
use Deployer\Exceptions\Contracts\RenderableExceptionInterface;
use Deployer\Exceptions\Contracts\ReportableExceptionInterface;

/**
 * Class Handler
 * @package Deployer\Exceptions
 */
class Handler
{
    /**
     * @var ReporterInterface|null
     */
    private static $reporter = null;

    /**
     * Returns an instance of Reporter to report the exception.
     *
     * @return SentryReporterAdapter|ReporterInterface|null
     *
     * @throws \Raven_Exception
     */
    public static function getReporter()
    {
        if (empty(self::$reporter) && class_exists('Raven_Client')) {
            $client = new \Raven_Client(config("SENTRY_DSN"));

            self::$reporter = new SentryReporterAdapter(
                $client->install()
            );
        }

        return self::$reporter;
    }

    /**
     * Handles the generated exception and prepares a response based on
     * its type.
     *
     * @param  $exception
     *
     * @return void
     *
     * @throws \Raven_Exception
     */
    public static function handle($exception)
    {
        if ($exception instanceof RenderableExceptionInterface) {
            $exception->render();
        }

        if ($exception instanceof ReportableExceptionInterface) {
            $exception->setReporter(self::getReporter())->report();
        } else {
            $reporter = self::getReporter();

            if (!empty($reporter)) {
                $reporter->report($exception);
            }
        }
    }
}