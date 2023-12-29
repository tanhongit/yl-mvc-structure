<?php

class ProductController extends Controller
{
    protected ProductModel $productModel;

    public function __construct()
    {
        $this->loadModel(ProductModel::class);
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
        $products = $this->productModel->getAll();
        $this->renderView('frontend.products.all', compact('products'));
    }

    public function show(): void
    {
        $id = $_GET['id'] ?? 0;
        $product = $this->productModel->findByID($id);

        $this->renderView('frontend.products.show', compact('product'));
    }

    public function store(): void
    {
        $data = array(
            'name' => 'product 1',
            'description' => 'product 1',
            'price' => 10
        );
        $this->productModel->store($data);

        $this->renderView('frontend.products.store', [
            'data' => $data,
        ]);
    }

    public function update(): void
    {
        $data = array(
            'id' => 4,
            'name' => 'product 2',
            'description' => 'product 2',
            'price' => 10
        );
        $this->productModel->updateData($data);

        $this->renderView('frontend.products.update', compact('data'));
    }

    public function delete(): void
    {
        $this->productModel->deleteByID(6);
    }
}
