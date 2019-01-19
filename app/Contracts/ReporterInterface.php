<?php

namespace Deployer\Contracts;

use Deployer\Exceptions\Exception;

/**
 * Interface ReporterInterface
 * @package Deployer\Contracts
 */
interface ReporterInterface
{
    public function report(Exception $exception);
}