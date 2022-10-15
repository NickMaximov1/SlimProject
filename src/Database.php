<?php
declare(strict_types=1);

namespace App;

use CustomExp\InvalidArgumentException;
use PDO;
use PDOException;

class Database
{
    private PDO $connection;

    /**
     * @throws InvalidArgumentException
     */
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

    /**
     * Return PDO connection
     * @return PDO
     */
    public function getConnection(): PDO
    {
        return $this->connection;
    }

    /**
     * Return result of query or null
     * @param string $sql
     * @param string $class
     * @param array $data
     * @return array|null
     * @throws PDOException
     */
    public function query(string $sql, string $class, array $data = []): ?array
    {
        $statement = $this->connection->prepare($sql);
        if(!$statement->execute($data)){
            throw new PDOException('The request can`t be done!');
        }

        $result = $statement->fetchAll(\PDO::FETCH_CLASS, $class);

        return empty($result) ? null : $result;
    }

    /**
     * Return true on success or throw PDOException
     * @param $sql
     * @param $data
     * @return bool
     * @throws PDOException
     */
    public function save($sql, $data): bool
    {
        $statement = $this->connection->prepare($sql);

        if ($statement->execute($data)) {
            return true;
        }

        throw new PDOException('The request can`t be done!');
    }
}