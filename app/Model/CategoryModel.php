<?php

class CategoryModel extends BaseModel
{
    const TABLE = 'categories';

    /**
     * @return array
     */
    public function getAll(): array
    {
        return $this->all(self::TABLE);
    }

    /**
     * @param $id
     *
     * @return array|false|string[]|null
     */
    public function findByID($id)
    {
        return $this->find(self::TABLE, $id);
    }

    /**
     * @param $id
     *
     * @return array|false|null
     */
    public function deleteByID($id)
    {
        return $this->delete(self::TABLE, $id);
    }

    /**
     * @param $data
     *
     * @return int|string
     */
    public function store($data)
    {
        return $this->create(self::TABLE, $data);
    }

    /**
     * @param $data
     *
     * @return int|string
     */
    public function updateData($data)
    {
        return $this->update(self::TABLE, $data);
    }

    /**
     * @param $attributes
     *
     * @return array|null
     */
    public function findByAttribute($attributes)
    {
        return $this->all(self::TABLE, $attributes);
    }
}
