<?php

namespace Deployer;

require_once __DEPLOYER_DIRECTORY__ . '/Container/Container.php';
require_once __DEPLOYER_DIRECTORY__ . '/Container/ContainerTrait.php';

use Deployer\Container\ContainerTrait;
use Deployer\Container\Container;

/**
 * Class Config
 * @package Config
 */
class Config implements Container
{
    use ContainerTrait;
}