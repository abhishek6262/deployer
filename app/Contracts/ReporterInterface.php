<?php

namespace App\Contracts;

use App\Exceptions\Exception;

/**
 * Interface ReporterInterface
 * @package App\Contracts
 */
interface ReporterInterface
{
    public function report(Exception $exception);
}