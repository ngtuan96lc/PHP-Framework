<?php

declare(strict_types=1);

namespace Eric\database;

/**
 * Class MySql Core
 */
class MySql implements DBInterface
{
    protected $connection = false;

    public function __construct()
    {
        $config = $this->getConfiguration();
        $host = $config['host'] ?? 'localhost';
        $user = $config['user'] ?? 'root';
        $password = $config['password'] ?? '';
        $dbname = $config['dbname'] ?? '';
        $port = $config['port'] ?? '3306';
        if (!$this->connection) {
            $this->connection = mysqli_connect($host, $user, $password, $dbname, (int)$port);
        }
    }

    /**
     * @return array
     */
    private function getConfiguration(): array
    {
        return $GLOBALS['config']['db']['connection'];
    }


    /**
     * @param $sqlQuery
     * @return bool|\mysqli_result|void
     */
    public function execute($sqlQuery)
    {
        /* write SQL statement into log file */
        $str = "[" . date("Y-m-d H:i:s") . "]" . " SQL: " . $sqlQuery . PHP_EOL;
        file_put_contents(SQL_LOG, $str,FILE_APPEND);

        $result = mysqli_query($this->connection, $sqlQuery);
        if (!$result) {
            $message = "Error Code: {$this->errorCode()}. Error message: {$this->errorInfo()}";
            die($message);
        }
        return $result;
    }

    /**
     * @param $sqlQuery
     * @return array|false|null
     */
    public function fetch($sqlQuery)
    {
        if ($result = $this->execute($sqlQuery)) {
            return mysqli_fetch_assoc($result);
        } else {
            return false;
        }
    }

    /**
     * @param $sqlQuery
     * @return array
     */
    public function fetchAll($sqlQuery): array
    {
        $result = $this->execute($sqlQuery);
        return mysqli_fetch_all($result);
    }

    /**
     * @return string
     */
    public function errorCode(): string
    {
        return mysqli_error($this->connection);
    }

    /**
     * @return string|null
     */
    public function errorInfo()
    {
        return mysqli_info($this->connection);
    }

    /**
     * @return int|string
     */
    public function getLatestInsertId()
    {
        return mysqli_insert_id($this->connection);
    }
}