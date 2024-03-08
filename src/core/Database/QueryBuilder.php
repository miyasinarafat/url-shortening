<?php

namespace Core\Database;

use PDO;
use PDOStatement;

class QueryBuilder
{
    public function __construct(
        protected PDO $connection,
        public PDOStatement|false|null $statement = null
    ) {
    }

    /**
     * Building query
     * @param string $query
     * @param array $params
     * @return $this
     */
    public function query(string $query, array $params = []): static
    {
        $this->statement = $this->connection->prepare($query);

        $this->statement->execute($params);

        return $this;
    }

    /**
     * Select all records from a database table.
     * @return bool|array
     */
    public function get(): bool|array
    {
        return $this->statement->fetchAll();
    }

    /**
     * Find single record from database table
     * @return mixed
     */
    public function find(): mixed
    {
        return $this->statement->fetch();
    }

    /**
     * Returns the ID of the last inserted row
     * @return int
     */
    public function lastInsertId(): int
    {
        return $this->connection->lastInsertId();
    }
}
