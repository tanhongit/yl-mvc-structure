<?php

class BaseModel extends Model
{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Create new data to table
     *
     * @param $table
     * @param $data
     *
     * @return int|string
     */
    public function create($table, $data): int|string
    {
        $data['id'] = 0; //set new row
        return $this->save($table, $data);
    }

    /**
     * Update data to table (use ID in $data)
     *
     * @param $table
     * @param $data
     *
     * @return int|string
     */
    public function update($table, $data): int|string
    {
        return $this->save($table, $data);
    }

    /**
     * Delete data from table by ID
     *
     * @param $table
     * @param $id
     *
     * @return array|false|null
     */
    public function delete($table, $id): false|array|null
    {
        return $this->destroy($table, $id);
    }

    /**
     * Get all data in the table
     *
     * @param $table
     * @param array $attributes
     *
     * @return array|null
     */
    public function all($table, array $attributes = array()): ?array
    {
        return $this->getByOptions($table, $attributes);
    }

    /**
     * Get data in table by ID
     *
     * @param $table
     * @param $id
     *
     * @return array|false|string[]|null
     */
    public function find($table, $id): array|false|null
    {
        return $this->getRecordByID($table, $id);
    }
}
