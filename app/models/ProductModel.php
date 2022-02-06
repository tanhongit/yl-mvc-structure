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
        return __METHOD__;
    }

    public function store($data)
    {
        $this->create(self::TABLE, $data);
    }
}
