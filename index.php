<?php

/**
 *-----------------------------------------------------------------------
 * The Deployer
 *-----------------------------------------------------------------------
 *
 * This acts as a Central Nervous System of the entire Deployment
 * application. It does all the Hard work of deploying the application
 * into the platform based on the environment and configurations
 * provided or set by the user.
 *
 * @author: Abhishek Prakash <prakashabhishek6262@gmail.com>
 * @package: The Deployer
 * @version: 0.1
 *
 */

define("__ROOT_DIRECTORY__", __DIR__);
define("__APP_DIRECTORY__", __DIR__ . "/app");
define("__SRC_DIRECTORY__", __DIR__ . "/src");

require_once __APP_DIRECTORY__ . "/init.php";