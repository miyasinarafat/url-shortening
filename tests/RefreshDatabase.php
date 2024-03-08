<?php

namespace Tests;

use Core\App;
use Core\Database\QueryBuilder;
use PDO;

trait RefreshDatabase
{
    /**
     * @return void
     */
    protected function setupSQLite(): void
    {
        $connection = new PDO('sqlite::memory:');

        App::bind('database', new QueryBuilder($connection));

        $connection->exec('
            DROP TABLE IF EXISTS short_links;
            CREATE TABLE short_links (
              id INTEGER PRIMARY KEY,
              target_url text NOT NULL
            );
        ');
        $connection->exec('
            DROP TABLE IF EXISTS `short_link_logs`;
            CREATE TABLE `short_link_logs` (
              `id` INTEGER PRIMARY KEY,
              `short_link_id` int NOT NULL,
              `user_ip` varchar(45) NOT NULL,
              `clicks` int NOT NULL DEFAULT 0,
              FOREIGN KEY (short_link_id) REFERENCES short_links(id)
            );
        ');
    }
}
