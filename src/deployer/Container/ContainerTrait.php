<?php

namespace Deployer\Container;

/**
 * Trait ContainerTrait
 * @package Deployer\Container
 */
trait ContainerTrait
{
    /**
     * @var array
     */
    public $items = [];

    /**
     * Returns all the items that are stored in the container.
     * 
     * @return array
     */
    public function all(): array
    {
        return $this->items;
    }

    /**
     * Registers the pair of key and value in the container.
     *
     * @param  string $key
     * @param  mixed $value
     *
     * @return void
     */
    public function bind(string $key, $value): void
    {
        $this->items[$key] = $value;
    }

    /**
     * Returns the total number of items that are available in the
     * container.
     * 
     * @return int
     */
    public function count(): int
    {
        return count($this->items);
    }

    /**
     * Returns the value stored for the key in the container.
     *
     * @param  string $key
     *
     * @return mixed
     */
    public function resolve(string $key)
    {
        if (array_key_exists($key, $this->items)) {
            return $this->items[$key];
        }

        return null;
    }

    /**
     * Registers the pair of key and value in the container.
     *
     * @param  string $key
     * @param  callable $value
     *
     * @return void
     */
    public function singleton(string $key, Callable $value): void
    {
        $this->items[$key] = call_user_func($value);
    }
}