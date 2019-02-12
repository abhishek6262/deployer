<?php

/**
 * Class Composer
 */
class Composer
{
    /**
     * @var string
     */
    protected $binPath;

    /**
     * @var string
     */
    protected $rootPath;

    /**
     * Composer constructor.
     *
     * @param  string $projectRootPath (Absolute Path [__DIR__]) The root directory of the project where composer.json file is stored.
     * @param  string $binDirPath (Absolute Path [__DIR__]) The directory where the composer should be installed.
     */
    public function __construct(string $projectRootPath, string $binDirPath = '')
    {
        $this->rootPath = rtrim($projectRootPath, '/');
        $this->binPath  = rtrim($binDirPath, '/');

        if (empty($this->binPath)) {
            $this->binPath = $this->rootPath . '/bin';
        }

        if (! file_exists($this->binPath)) {
            mkdir($this->binPath, 0777, true);
        }
    }

    /**
     * Executes the raw composer command.
     *
     * @param string $command
     *
     * @return void
     */
    public function rawCommand(string $command): void
    {
        $CURRENT_WORKING_DIRECTORY = getcwd();

        chdir($this->rootPath);

        $MAX_EXECUTION_TIME = 1800; // "30 Mins" for slow internet connections.

        set_time_limit($MAX_EXECUTION_TIME);

        $escaped_command = escapeshellcmd("php " . $this->binPath . "/composer " . $command);
        shell_exec($escaped_command);

        chdir($CURRENT_WORKING_DIRECTORY);
    }

    /**
     * Determines whether composer is installed in the project.
     *
     * @return bool
     */
    public function exists(): bool
    {
        return file_exists($this->binPath . "/composer") ? true : false;
    }

    /**
     * Installs composer in the project.
     *
     * @return void
     */
    public function install(): void
    {
        $CURRENT_WORKING_DIRECTORY = getcwd();

        chdir($this->rootPath);

        $MAX_EXECUTION_TIME = 1800; // "30 Mins" for slow internet connections.

        set_time_limit($MAX_EXECUTION_TIME);

        shell_exec("php -r \"copy('https://getcomposer.org/installer', 'composer-setup.php');\"");
        shell_exec("php composer-setup.php --install-dir=" . $this->binPath . " --filename=composer");
        shell_exec("php -r \"unlink('composer-setup.php');\"");

        chdir($CURRENT_WORKING_DIRECTORY);
    }

    /**
     * Installs the packages present in the composer.json file.
     *
     * @return void
     */
    public function installPackages(): void
    {
        $this->rawCommand("install");
    }

    /**
     * Determines whether the project has packages to be installed.
     *
     * @return bool
     */
    public function packagesExists(): bool
    {
        return file_exists($this->rootPath . "/composer.json") ? true : false;
    }

    /**
     * Determines whether the packages are already installed in the
     * project.
     *
     * @return bool
     */
    public function packagesInstalled(): bool
    {
        return file_exists($this->rootPath . "/vendor/") ? true : false;
    }
}