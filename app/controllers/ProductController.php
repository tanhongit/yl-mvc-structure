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
        var_dump($this->productModel->getAll());
    }

    public function show()
    {
        $id = $_GET['id'] ?? 0;
        $this->renderView('frontend.products.show');
        var_dump($this->productModel->findByID($id));
    }

    public function store()
    {
        $data = array(
            'name' => 'product 1',
            'description' => 'product 1',
            'price' => 10
        );
        $this->productModel->store($data);

        $this->renderView('frontend.products.store', array(
            'data' => $data,
        ));
    }

    public function update()
    {
        $data = array(
            'id' => 2,
            'name' => 'product 2',
            'description' => 'product 2',
            'price' => 10
        );
        $this->productModel->updateData($data);

        $this->renderView('frontend.products.update', array(
            'data' => $data,
        ));
    }
}
