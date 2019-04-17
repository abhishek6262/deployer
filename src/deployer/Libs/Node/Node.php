<?php

namespace Deployer\Libs\Node;

use abhishek6262\NodePHP\Node as BaseNode;
use abhishek6262\NodePHP\NPM;
use abhishek6262\NodePHP\System\Environment;
use Deployer\Container;

/**
 * Class Node
 * @package Deployer\Libs\Node
 */
final class Node
{
    /**
     * Node constructor.
     *
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        if (class_exists(NPM::class)) {
            $environment = new \abhishek6262\NodePHP\System\Environment(__PROJECT_DIRECTORY__, __BIN_DIRECTORY__);

            $container->bind('node', new BaseNode($environment));
            $container->bind('npm', new NPM($environment));
        }
    }
}
