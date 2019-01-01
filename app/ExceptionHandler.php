<?php

namespace App;

use App\Contracts\ExceptionHandlerInterface;

/**
 * Class ExceptionHandler
 * @package App
 */
class ExceptionHandler {
    /**
     * @var ExceptionHandlerInterface
     */
    protected $handler;

    /**
     * ExceptionHandler constructor.
     *
     * @param ExceptionHandlerInterface $handler
     */
    public function __construct(ExceptionHandlerInterface $handler) {
        $this->handler = $handler;
    }

    /**
     * Handles the exceptions thrown or errors occurred in the
     * application.
     *
     * @return void
     */
    public function handle() {
        $this->handler->report();
    }
}