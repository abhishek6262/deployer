<?php

/**
 *-----------------------------------------------------------------------
 * The Deployer
 *-----------------------------------------------------------------------
 *
 * This acts as a Central Nervous System of the entire Deployer
 * application. It does all the Hard work of deploying the application
 * into the platform based on the environment and configurations
 * provided or set by the user.
 *
 * @author  Abhishek Prakash <prakashabhishek6262@gmail.com>
 * @package The Deployer
 *
 */

define('__BIN_DIRECTORY__'     , __DIR__ . '/bin');
define('__DEPLOYER_DIRECTORY__', __DIR__ . '/deployer');
define('__PROJECT_DIRECTORY__' , __DIR__ . '/src');
define('__RECIPES_DIRECTORY__' , __DIR__ . '/recipes');
define('__ROOT_DIRECTORY__'    , __DIR__);

require_once __DEPLOYER_DIRECTORY__ . '/Deployer.php';

\Deployer\Deployer::instance()->init();