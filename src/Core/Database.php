<?php

namespace App\Core;

use App\Core\Exception\QueryException;
use PDO;
use PDOException;

require "Exceptions/QueryException.php";

class Database
{
    private $connection;
    private $statement;

    public function __construct(array $config = [], string $username = "root", string $password = "")
    {
        $dsn = "mysql:" . http_build_query($config, "", ";");
        $this->connection = new PDO($dsn, $username, $password, [
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]);
    }

    private function query(string $sql, array $params = [])
    {
        try {
            $this->statement = $this->connection->prepare($sql);
            $this->statement->execute($params);
        } catch (PDOException $e) {

            error_log($e->getMessage() . "\n", 3, __DIR__ . "/../../logs/error.log");

            throw new QueryException("Something went wrong, please try again later");
        }
    }

    public function fetchAll(string $sql, array $params = [])
    {
        $this->query($sql, $params);
        return $this->statement->fetchAll();
    }

    public function fetch(string $sql, array $params = [])
    {
        $this->query($sql, $params);
        return $this->statement->fetch();
    }

    public function execute(string $sql, array $params = [])
    {
        $this->query($sql, $params);
    }
     
    public function disConnect(){
        $this->connection = null;
    }
}
