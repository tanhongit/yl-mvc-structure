<?php

class Database
{
    protected $connection = null;
    public $connectResult;

    public function __construct()
    {
        $this->connectResult = $this->connect();
    }

    /**
     * Connection database
     *
     * @return mysqli|null
     */
    public function connect(): ?mysqli
    {
        // Create connection
        if (!$this->connection) {
            $this->connection = new mysqli(DB_HOST, DB_USER, DB_PASSWORD,
                DB_NAME);
            $this->connection->set_charset('utf8mb4');
        }
        return $this->connection;
    }

    /**
     * @param $sql
     *
     * @return mysqli_result|bool
     */
    public function _query($sql): mysqli_result|bool
    {
        return mysqli_query($this->connectResult, $sql);
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
     * @return array|void
     */
    public function getByOptions($table, array $options = array())
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
        $query = $this->_query($sql) or die(mysqli_error($this->connectResult));
        $data = array();
        if (mysqli_num_rows($query) > 0) {
            while ($row = mysqli_fetch_assoc($query)) {
                $data[] = $row;
            }
            mysqli_free_result($query);
        }
        return $data;
    }

    /**
     * Get data in table by id
     *
     * @param $table
     * @param $id
     * @param string $select
     *
     * @return array|false|void|null
     */
    public function getRecordByID($table, $id, string $select = '*')
    {
        $id = intval($id);
        $sql = /** @lang text */
            "SELECT $select FROM `$table` WHERE id=$id";
        $query = $this->_query($sql) or die(mysqli_error($this->connectResult));
        $data = null;
        if (mysqli_num_rows($query) > 0) {
            $data = mysqli_fetch_assoc($query);
            mysqli_free_result($query);
        }
        return $data;
    }

    /**
     * Save data to table (insert, update)
     *
     * @param $table
     * @param array $data
     *
     * @return int|string|void
     */
    public function save($table, array $data = array())
    {
        $values = array();
        foreach ($data as $key => $value) {
            $value = mysqli_real_escape_string($this->connectResult, $value);
            $values[] = "`$key`='$value'";
        }
        $id = intval($data['id']);
        if ($id > 0) {
            $sql = /** @lang text */
                "UPDATE `$table` SET " . implode(',', $values)
                . " WHERE id=$id";
        } else {
            $sql = /** @lang text */
                "INSERT INTO `$table` SET " . implode(',', $values);
        }
        $this->_query($sql) or die(mysqli_error($this->connectResult));
        return ($id > 0) ? $id : mysqli_insert_id($this->connectResult);
    }

    /**
     * Delete data from table by ID
     *
     * @param $table
     * @param $id
     *
     * @return array|false|void|null
     */
    public function destroy($table, $id)
    {
        $record = $this->getRecordByID($table, $id);

        if ($record) {
            $sql = /** @lang text */
                "DELETE FROM `$table` WHERE id=$id";
            $this->_query($sql) or die(mysqli_error($this->connectResult));
        }

        return $record;
    }
}
