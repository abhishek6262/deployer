<?php

namespace Deployer;

use PDO;

/**
 * Class Database
 * @package Deployer
 */
final class Database
{
    /**
     * @var PDO
     */
    private $connection;

    /**
     * @var string
     */
    private $CON_TYPE;

    /**
     * @var string
     */
    private $DB_NAME;

    /**
     * @var string
     */
    private $DB_USER;

    /**
     * @var string
     */
    private $DB_PASS;

    /**
     * @var string
     */
    private $DB_HOST;

    /**
     * @var int
     */
    private $DB_PORT;

    /**
     * Database constructor.
     *
     * @param string $DB_NAME
     * @param string $DB_USER
     * @param string $DB_PASS
     * @param string $DB_HOST
     * @param int $DB_PORT
     */
    public function __construct(string $DB_NAME, string $DB_USER, string $DB_PASS, string $DB_HOST = 'localhost', int $DB_PORT = 3306, string $CON_TYPE = 'mysql')
    {
        $this->DB_NAME = $DB_NAME;
        $this->DB_USER = $DB_USER;
        $this->DB_PASS = $DB_PASS;
        $this->DB_HOST = $DB_HOST;
        $this->DB_PORT = $DB_PORT;
        $this->CON_TYPE = $CON_TYPE;
    }

    /**
     * Returns the connection of the database.
     *
     * @return PDO
     */
    public function connection(): PDO
    {
        if (isset($this->connection)) {
            return $this->connection;
        }

        $this->connection = new PDO(
            "{$this->CON_TYPE}:host={$this->DB_HOST}; port={$this->DB_PORT}; dbname={$this->DB_NAME};",
            $this->DB_USER,
            $this->DB_PASS,
            [
                PDO::ATTR_PERSISTENT => true
            ]
        );

        $this->connection->setAttribute(
            PDO::ATTR_ERRMODE,
            PDO::ERRMODE_EXCEPTION
        );

        static::preserveConnectionForNextRequests(
            $this->DB_NAME,
            $this->DB_USER,
            $this->DB_PASS,
            $this->DB_HOST,
            $this->DB_PORT
        );

        return $this->connection;
    }

    /**
     * Determines whether a connection has been reserved for the request.
     *
     * @return bool
     */
    public static function hasPreservedConnection(): bool
    {
        if (isset($_SESSION['DB_NAME'], $_SESSION['DB_USER'], $_SESSION['DB_PASS'], $_SESSION['DB_HOST'], $_SESSION['DB_PORT'])) {
            return true;
        }

        return false;
    }

    /**
     * Imports the sql file into the database.
     *
     * @param string $sqlFile
     * @param string|null $tablePrefix
     * @param string|null $InFilePath
     *
     * @return bool
     */
    public function importSqlFile(string $sqlFile, string $tablePrefix = null, string $InFilePath = null): bool
    {
        $MAX_EXECUTION_TIME = 300; // "5 Mins" for large files.

        set_time_limit($MAX_EXECUTION_TIME);

        try {
            // Enable LOAD LOCAL INFILE
            $this->connection->setAttribute(PDO::MYSQL_ATTR_LOCAL_INFILE, true);

            $errorDetect = false;

            // Temporary variable, used to store current query
            $tmpLine = '';

            // Read in entire file
            $lines = file($sqlFile);

            // Loop through each line
            foreach ($lines as $line) {
                // Skip it if it's a comment
                if (substr($line, 0, 2) == '--' || trim($line) == '') {
                    continue;
                }

                // Read & replace prefix
                $line = str_replace(['<<prefix>>', '<<InFilePath>>'], [$tablePrefix, $InFilePath], $line);

                // Add this line to the current segment
                $tmpLine .= $line;

                // If it has a semicolon at the end, it's the end of the query
                if (substr(trim($line), -1, 1) == ';') {
                    try {
                        // Perform the Query
                        $this->connection->exec($tmpLine);
                    } catch (\PDOException $e) {
                        echo "<br><pre>Error performing Query: '<strong>" . $tmpLine . "</strong>': " . $e->getMessage() . "</pre>\n";
                        $errorDetect = true;
                    }

                    // Reset temp variable to empty
                    $tmpLine = '';
                }
            }

            // Check if error is detected
            if ($errorDetect) {
                return false;
            }
        } catch (\Exception $e) {
            echo "<br><pre>Exception => " . $e->getMessage() . "</pre>\n";
            return false;
        }

        return true;
    }

    /**
     * Saves the database connection details for the next requests.
     *
     * @param string $DB_NAME
     * @param string $DB_USER
     * @param string $DB_PASS
     * @param string $DB_HOST
     * @param int $DB_PORT
     * @param string $CON_TYPE
     *
     * @return void
     */
    public static function preserveConnectionForNextRequests(string $DB_NAME, string $DB_USER, string $DB_PASS, string $DB_HOST = 'localhost', int $DB_PORT = 3306, string $CON_TYPE = 'mysql')
    {
        $_SESSION['DB_NAME'] = $DB_NAME;
        $_SESSION['DB_USER'] = $DB_USER;
        $_SESSION['DB_PASS'] = $DB_PASS;
        $_SESSION['DB_HOST'] = $DB_HOST;
        $_SESSION['DB_PORT'] = $DB_PORT;
    }

    /**
     * Regenerates and returns the preserved database connection.
     *
     * @return self
     */
    public static function regeneratePreservedConnection(): self
    {
        return new static(
            $_SESSION['DB_NAME'],
            $_SESSION['DB_USER'],
            $_SESSION['DB_PASS'],
            $_SESSION['DB_HOST'],
            $_SESSION['DB_PORT']
        );
    }
}
