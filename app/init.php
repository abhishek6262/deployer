<?php

/**
 * We'll begin by autoloading the files of the application with Composer
 * Protocols to initialize the classes automatically when required.
 */

require __DIR__ . "/../vendor/autoload.php";

/**
 * Next, we'll introduce an error handler to log or report the errors
 * occuring in the application.
 */

$client = new \App\Adapters\SentryAdapter( new \Raven_Client( config( "SENTRY_DSN" ) ) );
$errors = new \App\ExceptionHandler( $client );
$errors->handle();