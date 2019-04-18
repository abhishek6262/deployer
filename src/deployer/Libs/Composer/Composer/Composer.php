<?php

namespace abhishek6262\Composer;

require_once __DIR__ . "/functions.php";
require_once __DIR__ . "/System/Environment.php";
require_once __DIR__ . "/System/Response.php";

use abhishek6262\Composer\System\Environment;
use abhishek6262\Composer\System\Response;

/**
 * Class Composer
 * @package abhishek6262\Composer
 */
class Composer
{
    /**
     * @var Environment
     */
    protected $environment;

    /**
     * Composer constructor.
     *
     * @param  string $rootPath (Absolute Path [__DIR__]) The root directory of the project where composer.json file is stored.
     * @param  string $binPath (Absolute Path [__DIR__]) The directory where the composer should be installed.
     */
    public function __construct(string $rootPath, string $binPath = '')
    {
        $this->environment = new Environment($rootPath, $binPath);
    }

    /**
     * Executes the raw composer command.
     *
     * @param  string $command
     *
     * @return Response
     */
    public function rawCommand(string $command): Response
    {
        $CURRENT_WORKING_DIRECTORY = getcwd();

        chdir($this->environment->rootPath);

        $MAX_EXECUTION_TIME = 1800; // "30 Mins" for slow internet connections.

        set_time_limit($MAX_EXECUTION_TIME);

        exec( escapeshellcmd($this->environment->getPHPPath() . " " . $this->environment->binPath . "/composer " . $command) . " 2>&1", $message, $code );

        chdir($CURRENT_WORKING_DIRECTORY);

        return new Response($message, $code);
    }

    /**
     * Determines whether composer is installed in the project.
     *
     * @return bool
     */
    public function exists(): bool
    {
        return file_exists($this->environment->binPath . "/composer") ? true : false;
    }

    /**
     * Installs composer in the project.
     *
     * @return void
     */
    public function install()
    {
        $this->environment->install();
    }

    /**
     * Installs the packages present in the composer.json file.
     *
     * @return Response
     */
    public function installPackages(): Response
    {
        return $this->rawCommand("install");
    }

    /**
     * Determines whether the project has packages to be installed.
     *
     * @return bool
     */
    public function packagesExists(): bool
    {
        return file_exists($this->environment->rootPath . "/composer.json") ? true : false;
    }

    /**
     * Determines whether the packages are already installed in the
     * project.
     *
     * @return bool
     */
    public function packagesInstalled(): bool
    {
        return file_exists($this->environment->rootPath . "/vendor/") ? true : false;
    }
}
