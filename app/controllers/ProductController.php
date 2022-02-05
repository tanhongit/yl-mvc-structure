<?php

class ProductController extends Controller
{
    private $productModel;

    public function __construct()
    {
        $this->loadModel('ProductModel');
        $this->productModel = new ProductModel;
    }

    public function index()
    {
        $this->renderView('frontend.products.index');
    }

    public function run()
    {
        echo __METHOD__;
    }

    public function all()
    {
        $this->renderView('frontend.products.all');
        var_dump($this->productModel->all(ProductModel::TABLE));
    }

    public function show()
    {
        $id = $_GET['id'];
        $this->renderView('frontend.products.show');
        var_dump($this->productModel->find(ProductModel::TABLE, $id));
    }
}
