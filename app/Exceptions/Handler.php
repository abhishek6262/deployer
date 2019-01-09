<?php

namespace App\Exceptions;

use App\Adapters\SentryReporterAdapter;
use App\Contracts\ReporterInterface;
use App\Exceptions\Contracts\RenderableExceptionInterface;
use App\Exceptions\Contracts\ReportableExceptionInterface;

/**
 * Class Handler
 * @package App\Exceptions
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
     * @param Exception $exception
     *
     * @return void
     *
     * @throws \Raven_Exception
     */
    public static function handle(Exception $exception)
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