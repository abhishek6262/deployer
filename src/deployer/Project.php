<?php

namespace Deployer;

/**
 * Class Project
 * @package Deployer
 */
class Project
{
    /**
     * @var string
     */
    protected $path;

    /**
     * Returns the path on which the project is stored.
     *
     * @return string
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Set the path to the project where it is stored.
     *
     * @param  string $path
     *
     * @return void
     */
    public function setPath(string $path = ''): void
    {
        $this->path = $path;
    }
}