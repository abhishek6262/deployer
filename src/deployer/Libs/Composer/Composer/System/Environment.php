<?php

namespace abhishek6262\Composer\System;

/**
 * Class Environment
 * @package abhishek6262\Composer\System
 */
class Environment
{
    /**
     * @var string
     */
    public $binPath;

    /**
     * @var string
     */
    public $rootPath;

    /**
     * Environment constructor.
     *
     * @param  string $rootPath
     * @param  string $binPath
     */
    public function __construct(string $rootPath, string $binPath = '')
    {
        $this->rootPath = rtrim($rootPath, '/');
        $this->binPath  = rtrim($binPath, '/');

        if (empty($this->binPath)) {
            $this->binPath = $this->rootPath . '/bin';
        }

        if (!file_exists($this->binPath)) {
            mkdir($this->binPath, 0777, true);
        }
    }

    /**
     * Installs composer in the project.
     *
     * @return void
     */
    public function install()
    {
        $MAX_EXECUTION_TIME = 1800; // "30 Mins" for slow internet connections.

        set_time_limit($MAX_EXECUTION_TIME);

        $PATH = $this->getPHPPath();

        shell_exec($PATH . " -r \"copy('https://getcomposer.org/installer', 'composer-setup.php');\"");
        shell_exec($PATH . " composer-setup.php --install-dir=" . $this->binPath . " --filename=composer");
        shell_exec($PATH . " -r \"unlink('composer-setup.php');\"");
    }

    /**
     * Returns the path of PHP set in the environment.
     *
     * @return string
     */
    public function getPHPPath(): string
    {
        $PATH = array_values(array_filter(explode(";", getenv("PATH")), function ($value) {
            return endsWith($value, 'php') || endsWith($value, 'php\\');
        }));

        $PATH = rtrim($PATH[0], '\\');
        $PATH .= '\\php';

        return addslashes($PATH);
    }
}
