<?php

namespace App\Core;

use App\Core\Exceptions\QueryException;
use PDO;
use PDOException;

class Database
{
    private $connection;
    private $statement;

    public function __construct(array $config = [])
    {
        $dsn = "mysql:" . http_build_query($config, "", ";");
        $this->connection = new PDO($dsn, $config['username'], $config['password'], [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
        ]);
    }

    private function query(string $sql, array $params = [])
    {
        try {
            $this->statement = $this->connection->prepare($sql);
            $this->statement->execute($params);
        } catch (PDOException $e) {
            throw new QueryException($e->getMessage());
        }
    }

    public function fetchAll(string $sql, string $class = null )
    {
        $this->query($sql);
    
        return $this->statement->fetchAll(PDO::FETCH_CLASS, $class);
    }

    public function fetch(string $sql , array $params = [] , string $class = null)
    {
        $this->query($sql, $params);
    if($class){
        $this->statement->setFetchMode(PDO::FETCH_CLASS , $class);
    }else{
        $this->statement->setFetchMode(PDO::FETCH_ASSOC);
    }
        return $this->statement->fetch();
    }

    public function execute(string $sql, array $params = [])
    {
        $this->query($sql, $params);
    }

    public function disConnect()
    {
        $this->connection = null;
    }

    public function getLastId(){
       return $this->connection->lastInsertId();
    }
}