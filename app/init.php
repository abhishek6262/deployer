<?php

require_once __APP_DIRECTORY__ . "/functions.php";
require_once __APP_DIRECTORY__ . "/Exceptions/Contracts/RenderableExceptionInterface.php";
require_once __APP_DIRECTORY__ . "/Exceptions/Contracts/ReportableExceptionInterface.php";
require_once __APP_DIRECTORY__ . "/Exceptions/Exception.php";
require_once __APP_DIRECTORY__ . "/Exceptions/Handler.php";

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
 * Composer and all its pacakages and we fail then we'll ask the user to
 * install it manually.
 */

if (!composer_exists()) {
    composer_install();
}

if (!composer_packages_exists()) {
    composer_packages_install();
}

/**
 * Next, we'll autoload the files with the help of Composer to bootstrap
 * our application.
 */

require_once __ROOT_DIRECTORY__ . "/vendor/autoload.php";

/**
 * Now when the application has been booted so it is the perfect time to
 * check whether the application requires Node Modules and if yes then we
 * should prepare the environment for it.
 */

if (npm_required() && !npm_exists()) {
    npm_install();
}