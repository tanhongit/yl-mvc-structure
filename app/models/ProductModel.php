<?php

class ProductModel extends BaseModel
{
    const TABLE = 'products';

    public function getAll()
    {
        return $this->all(ProductModel::TABLE);
    }

    public function findByID($id)
    {
        return __METHOD__;
    }

    public function deleteByID($id)
    {
        return __METHOD__;
    }
}
