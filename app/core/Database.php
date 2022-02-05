<?php

class Database
{
    private $connection = NULL;

    public function __construct()
    {
        // Create connection
        if (!$this->connection) {
            $this->connection = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME);
            $this->connection->set_charset('utf8mb4');
        }
        return $this->connection;
    }
}
