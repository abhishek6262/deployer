<?php

namespace App\Exceptions;

/**
 * Class Exception
 * @package App\Exceptions
 */
class Exception extends \Exception
{
    /**
     * Generates a nice looking template for the thrown exception.
     *
     * @return void
     */
    public function render()
    {
        //
    }

    /**
     * Reports the exception thrown to the third-party or by logging it
     * into the file.
     *
     * @return void
     */
    public function report()
    {
        //
    }
}