<?php
declare(strict_types=1);

namespace App;

use http\Exception\InvalidArgumentException;
use PDO;
use PDOException;

class Database
{
    private PDO $connection;

    public function __construct()
    {
        try {
            $config = new Config();
            $configData = $config->getData();
            $this->connection = new PDO(
                $configData['dsn'],
                $configData['username'],
                $configData['password']
            );
        } catch (PDOException $exception) {
            throw new InvalidArgumentException('Database error: ' . $exception->getMessage());
        }
        $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $this->connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_CLASS);
    }

    public function getConnection(): PDO
    {
        return $this->connection;
    }

    public function query(string $sql, string $class, array $data = [])
    {
        $statement = $this->connection->prepare($sql);
        if(!$statement->execute($data)){
            throw new PDOException('The request can`t be done!');
        }

        $result = $statement->fetchAll(\PDO::FETCH_CLASS, $class);
        return empty($result) ? null : $result;

    }

    public function save($sql, $data)
    {
        $statement = $this->connection->prepare($sql);
        return !$statement->execute($data) ? throw new PDOException('The request can`t be done!') :
            true;
    }

}