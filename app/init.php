<?php

namespace App;
// just user buffer in any case
ob_start();

/**
 * Firt, We are checking if the composer is installed if not than
 * We will install it programmatically
 */

$installer_file = __DIR__.'\installer\composer.sh';
$output = shell_exec("$installer_file 2>&1");
echo $output;

/**
 * We'll begin by autoloading the files of the application with Composer
 * Protocols to initialize the classes automatically when required.
 */

require __DIR__ . "/../vendor/autoload.php";

/**
 * Next, we'll introduce an error handler to log or report the errors
 * occuring in the application.
 */

$client = new Adapters\SentryAdapter( new \Raven_Client( config( "SENTRY_DSN" ) ) );
$errors = new ExceptionHandler( $client );
$errors->handle();
