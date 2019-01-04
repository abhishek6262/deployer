<?php

namespace App\Exceptions;

/**
 * Class Handler
 * @package App\Exceptions
 */
class Handler
{
    /**
     * @var \Raven_Client|null
     */
    private static $reporter = null;

    /**
     * Handles the generated exception and prepares a response based on
     * its type.
     *
     * @param \Exception $exception
     *
     * @return void
     *
     * @throws \Raven_Exception
     */
    public static function handle(\Exception $exception)
    {
        if ($exception instanceof RenderableExceptionInterface) {
            $exception->render();
        }

        if ($exception instanceof ReportableExceptionInterface) {
            if (empty(self::$reporter)) {
                self::$reporter = new \Raven_Client(config("SENTRY_DSN"));
                self::$reporter->install();
            }

            $exception->report();
        }
    }
}