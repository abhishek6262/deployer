<?php

namespace App\Services;

use PDO;
use Rah\Danpu\Dump;
use Rah\Danpu\Export;
use Rah\Danpu\Import;

/**
 * Class Database
 * @package App\Services
 */
class Database extends PDO
{
    /**
     * @var null
     */
    public static $connection = null;

    /**
     * Returns an instance of dumped file for importing and exporting.
     *
     * @param string $file
     *
     * @return Dump
     */
    private function dumpFile(string $file): Dump
    {
        $DATABASE_NAME = config('DATABASE_NAME');
        $DATABASE_USER = config('DATABASE_USER');
        $DATABASE_PASS = config('DATABASE_PASS');
        $DATABASE_TYPE = config('DATABASE_TYPE');
        $DATABASE_HOST = config('DATABASE_HOST');
        $DATABASE_PORT = config('DATABASE_PORT');
        $DSN           = "$DATABASE_TYPE:host=$DATABASE_HOST;port=$DATABASE_PORT;dbname=$DATABASE_NAME";

        $dump = new Dump;
        $dump
            ->disableForeignKeyChecks(true)
            ->disableUniqueKeyChecks(true)
            ->file($file)
            ->dsn($DSN)
            ->user($DATABASE_USER)
            ->pass($DATABASE_PASS)
            ->tmp(__SRC_DIRECTORY__);

        return $dump;
    }

    /**
     * Exports the database into the file.
     *
     * @param  string $path
     *
     * @return string
     */
    public function export($path = __SRC_DIRECTORY__): string
    {
        $file = $path . '/' . uniqid("deployer_db_") . '.sql';

        new Export( $this->dumpFile($file) );

        return $file;
    }

    /**
     * Imports the file's data on the database.
     *
     * @param $file
     *
     * @return Database
     */
    public function import($file): self
    {
        new Import( $this->dumpFile($file) );

        return $this;
    }

    /**
     * Returns an instance of database connection.
     *
     * @return Database|null
     */
    public static function connect(): Database
    {
        if (!empty(self::$connection)) {
            return self::$connection;
        }

        $DATABASE_NAME = config('DATABASE_NAME');
        $DATABASE_USER = config('DATABASE_USER');
        $DATABASE_PASS = config('DATABASE_PASS');
        $DATABASE_TYPE = config('DATABASE_TYPE');
        $DATABASE_HOST = config('DATABASE_HOST');
        $DATABASE_PORT = config('DATABASE_PORT');
        $DSN           = "$DATABASE_TYPE:host=$DATABASE_HOST;port=$DATABASE_PORT;dbname=$DATABASE_NAME";

        self::$connection = new static(
            $DSN,
            $DATABASE_USER,
            $DATABASE_PASS,
            [
                PDO::ATTR_PERSISTENT => true
            ]
        );

        self::$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        return self::$connection;
    }
}
