<?php

namespace App\Core;

use PDO;

class Database
{
    private $connection;
    private $statement;

    public function __construct(array $config = [], string $username = "root", string $password = "")
    {
        $dsn = "mysql:" . http_build_query($config, "", ";");
        $this->connection = new PDO($dsn, $username, $password, [
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]);
    }

    private function query(string $sql, array $params = [])
    {
        $this->statement = $this->connection->prepare($sql);
        $this->statement->execute($params);
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
}