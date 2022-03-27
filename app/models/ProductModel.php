<?php

class ProductModel extends BaseModel
{
    const TABLE = 'products';

    /**
     * @return array|void
     */
    public function getAll()
    {
        return $this->all(self::TABLE);
    }

    /**
     * @param $id
     * @return array|false|string[]|void|null
     */
    public function findByID($id)
    {
        return $this->find(self::TABLE, $id);
    }

    /**
     * @param $id
     */
    public function deleteByID($id)
    {
        return $this->delete(self::TABLE, $id);
    }

    /**
     * @param $data
     * @return int|string|void
     */
    public function store($data)
    {
        return $this->create(self::TABLE, $data);
    }

    /**
     * @param $data
     * @return int|string|void
     */
    public function updateData($data)
    {
        return $this->update(self::TABLE, $data);
    }

    /**
     * @param $attributes
     * @return array|void
     */
    public function findByAttribute($attributes)
    {
        return $this->all(self::TABLE, $attributes);
    }
}
