<?php

namespace Deployer\Libs\Composer;

require_once 'Composer/Composer.php';

use abhishek6262\Composer\Composer as BaseComposer;
use Deployer\Container;

/**
 * Class Composer
 * @package Deployer\Libs\Composer
 */
final class Composer
{
    /**
     * Composer constructor.
     *
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $container->bind('composer', new BaseComposer(__PROJECT_DIRECTORY__, __BIN_DIRECTORY__));
    }
}