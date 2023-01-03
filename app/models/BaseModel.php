<?php

class BaseModel extends Model
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Create new data to table
     * @param $table
     * @param $data
     * @return int|string
     */
    public function create($table, $data)
    {
        $data['id'] = 0; //set new row
        return $this->save($table, $data);
    }

    /**
     * Update data to table (use ID in $data)
     * @param $table
     * @param $data
     * @return int|string
     */
    public function update($table, $data)
    {
        return $this->save($table, $data);
    }

    /**
     * Delete data from table by ID
     * @param $table
     * @param $id
     * @return array|false|null
     */
    public function delete($table, $id)
    {
        return $this->destroy($table, $id);
    }

    /**
     * Get all data in the table
     * @param $table
     * @param array $attributes
     * @return array|null
     */
    public function all($table, array $attributes = array())
    {
        return $this->getByOptions($table, $attributes);
    }

    /**
     * Get data in table by ID
     * @param $table
     * @param $id
     * @return array|false|string[]|null
     */
    public function find($table, $id)
    {
        return $this->getRecordByID($table, $id);
    }

    /**
     * @param $sql
     * @return bool|mysqli_result
     */
    public function _query($sql)
    {
        return mysqli_query($this->connectResult, $sql);
    }

    /**
     * Escape special characters in string
     * @param $str
     * @return string
     */
    public function escape($str): string
    {
        return mysqli_real_escape_string($this->connectResult, $str);
    }
}