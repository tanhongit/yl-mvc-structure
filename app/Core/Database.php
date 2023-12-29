<?php

class Database
{
    protected ?mysqli $connection = null;

    /**
     * @throws Exception
     */
    public function __construct()
    {
        $this->connect();
    }

    /**
     * Execute a SQL query using prepared statements.
     *
     * @param string $sql The SQL query to execute.
     * @param array $params The parameters to bind to the query.
     *
     * @return mysqli_stmt The prepared statement.
     * @throws Exception
     */
    protected function executeQuery(string $sql, array $params = []): mysqli_stmt
    {
        $stmt = $this->connection->prepare($sql);

        if (!$stmt) {
            throw new Exception('Prepare error: ' . $this->connection->error);
        }

        if ($params) {
            $stmt->bind_param(str_repeat('s', count($params)), ...$params);
        }

        if (!$stmt->execute()) {
            throw new Exception('Execute error: ' . $stmt->error);
        }

        return $stmt;
    }

    /**
     * Fetch data from the database using prepared statements.
     *
     * @param string $sql The SQL query to execute.
     * @param array $params The parameters to bind to the query.
     *
     * @return array The fetched data.
     * @throws Exception
     */
    public function fetchData(string $sql, array $params = []): array
    {
        $stmt = $this->executeQuery($sql, $params);
        $result = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
        $stmt->close();
        return $result;
    }

    /**
     * Establish a database connection.
     *
     * @return void
     * @throws Exception
     */
    protected function connect(): void
    {
        if ($this->connection === null) {
            $this->connection = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME, DB_PORT);

            if ($this->connection->connect_error) {
                throw new Exception('Connection error: ' . $this->connection->connect_error);
            }

            $this->connection->set_charset('utf8mb4');
        }
    }

    /**
     * Execute the query and process the returned results
     *
     * @param $sql
     *
     * @return mixed
     */
    public function select($sql): mixed
    {
        $sql->execute();
        return $sql->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    /**
     * Get the data in the table according to the arbitrary request of option
     *
     * @param $table
     * @param array $options
     *
     * @return array
     * @throws Exception
     */
    public function getByOptions($table, array $options = []): array
    {
        $select = $options['select'] ?? '*';
        $where = isset($options['where']) ? 'WHERE ' . $options['where'] : '';
        $join = isset($options['join']) ? 'LEFT JOIN ' . $options['join'] : '';
        $order_by = isset($options['order_by'])
            ? 'ORDER BY '
            . $options['order_by'] : '';
        $limit = isset($options['offset']) && isset($options['limit'])
            ? 'LIMIT ' . $options['offset'] . ',' . $options['limit'] : '';

        $sql = /** @lang text */
            "SELECT $select FROM `$table` $join $where $order_by $limit";

        $query = $this->executeQuery($sql);
        $result = $query->get_result()->fetch_all(MYSQLI_ASSOC);
        $query->close();

        return $result;
    }

    /**
     * Get data in table by id
     *
     * @param $table
     * @param $id
     * @param string $select
     *
     * @return array|false|null
     * @throws Exception
     */
    public function getRecordByID($table, $id, string $select = '*'): false|array|null
    {
        $id = intval($id);
        $sql = /** @lang text */
            "SELECT $select FROM `$table` WHERE id=$id";
        $query = $this->executeQuery($sql);
        $result = $query->get_result()->fetch_assoc();
        $query->close();
        return $result;
    }

    /**
     * Save data to table (insert, update)
     *
     * @param string $table
     * @param array $data
     *
     * @return int|string
     * @throws Exception
     */
    public function save(string $table, array $data): int|string
    {
        $id = intval($data['id'] ?? 0);
        unset($data['id']);

        $columns = array_keys($data);
        if ($id > 0) {
            $sets = implode(', ', array_map(fn($col) => "`$col` = ?", $columns));
            $params = array_values($data);
            $params[] = $id;
            $sql = /** @lang text */
                "UPDATE `$table` SET $sets WHERE `id` = ?";
        } else {
            $placeholders = implode(', ', array_fill(0, count($columns), '?'));
            $params = array_values($data);
            $sql = /** @lang text */
                "INSERT INTO `$table` (`" . implode('`, `', $columns) . "`) VALUES ($placeholders)";
        }

        $stmt = $this->executeQuery($sql, $params);
        $stmt->close();

        return $id > 0 ? $id : $this->connection->insert_id;
    }

    /**
     * Delete data from table by ID
     *
     * @param $table
     * @param $id
     *
     * @return array|false|null
     * @throws Exception
     */
    public function destroy($table, $id): false|array|null
    {
        $record = $this->getRecordByID($table, $id);

        if ($record) {
            $sql = /** @lang text */
                "DELETE FROM `$table` WHERE id=$id";
            $stmt = $this->executeQuery($sql, [$id]);
            $stmt->close();
        }

        return $record;
    }
}
