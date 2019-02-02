<?php

namespace Deployer\Container;

/**
 * Interface Container
 * @package Deployer\Container
 */
interface Container
{
    /**
     * Returns all the items that are stored in the container.
     * 
     * @return array
     */
    public function all(): array;

    /**
     * Registers the pair of key and value in the container.
     *
     * @param  string $key
     * @param  mixed $value
     *
     * @return void
     */
    public function bind(string $key, $value): void;

    /**
     * Returns the total number of items that are available in the
     * container.
     * 
     * @return int
     */
    public function count(): int;

    /**
     * Returns the value stored for the key in the container.
     *
     * @param  string $key
     *
     * @return mixed
     */
    public function resolve(string $key);

    /**
     * Registers the pair of key and value in the container.
     *
     * @param  string $key
     * @param  callable $value
     *
     * @return void
     */
    public function singleton(string $key, Callable $value): void;
}