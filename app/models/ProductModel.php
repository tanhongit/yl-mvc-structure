<?php

class ProductModel extends BaseModel
{
    const TABLE = 'products';

    public function getAll()
    {
        return $this->all(self::TABLE);
    }

    public function findByID($id)
    {
        return $this->find(self::TABLE, $id);
    }

    public function deleteByID($id)
    {
        return $this->delete(self::TABLE, $id);
    }

    public function store($data)
    {
        $this->create(self::TABLE, $data);
    }

    public function updateData($data)
    {
        $this->update(self::TABLE, $data);
    }
}
