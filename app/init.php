<?php

require_once __DIR__ . "/functions.php";
require_once __DIR__ . "/Exceptions/Exception.php";
require_once __DIR__ . "/Exceptions/Handler.php";
require_once __DIR__ . "/Exceptions/RenderableExceptionInterface.php";
require_once __DIR__ . "/Exceptions/ReportableExceptionInterface.php";

/**
 * First and foremost we'll start off by attaching a Error or Exception
 * handler for the application that will be helpful to present errors in
 * a nice and more detailed manner.
 */

set_exception_handler([\App\Exceptions\Handler::class, 'handle']);

/**
 * Next, we'll proceed by checking if the Composer exists in the
 * environment since our complete application is based on Composer so
 * it is necessary to have Composer installed. We'll try installing
 * Composer and if we fail then we'll ask the user to install it manually.
 */

if (composer_exists()) {
    composer_install();
}

/**
 * Next, we'll autoload the files with the help of Composer to bootstrap
 * our application.
 */

require_once __DIR__ . "/../vendor/autoload.php";