<?php

class ProductController extends Controller
{
    protected ProductModel $productModel;

    public function __construct()
    {
        $this->loadModel('ProductModel');
        $this->productModel = new ProductModel();
    }

    public function index(): void
    {
        $this->renderView('frontend.products.index');
    }

    public function run(): void
    {
        echo __METHOD__;
    }

    public function all(): void
    {
        $this->renderView('frontend.products.all');
        var_dump($this->productModel->getAll());
    }

    public function show(): void
    {
        $id = $_GET['id'] ?? 0;
        $this->renderView('frontend.products.show');
        var_dump($this->productModel->findByID($id));
    }

    public function store(): void
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

    public function update(): void
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

    public function delete(): void
    {
        $this->productModel->deleteByID(6);
    }
}
