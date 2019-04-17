<?php

/**
 *-----------------------------------------------------------------------
 * Deployer
 *-----------------------------------------------------------------------
 *
 * This application is responsible for performing the deployment of the
 * PHP applications with ease, as it brings all the command line tasks to
 * the GUI-level.
 *
 * @author  Abhishek Prakash <prakashabhishek6262@gmail.com>
 * @package Deployer
 *
 */

session_start();

define('__BIN_DIRECTORY__'     , __DIR__ . '/bin');
define('__DEPLOYER_DIRECTORY__', __DIR__ . '/deployer');
define('__PROJECT_DIRECTORY__' , __DIR__ . '/src');
define('__RECIPES_DIRECTORY__' , __DIR__ . '/recipes');
define('__ROOT_DIRECTORY__'    , __DIR__);

if (file_exists($autoload = __ROOT_DIRECTORY__ . '/vendor/autoload.php')) {
    /** @noinspection PhpIncludeInspection */
    require_once $autoload;
}

require_once __DEPLOYER_DIRECTORY__ . '/Engine.php';

$engine = new \Deployer\Engine();
$engine->start();
