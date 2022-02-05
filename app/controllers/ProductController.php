<?php

class ProductController extends Controller
{
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

    public function show()
    {
        $this->renderView('frontend.products.show');
        echo '<br>' . $this->productModel->getAll();
        echo getenv('RFGRGHISR_RFG');
    }
}
