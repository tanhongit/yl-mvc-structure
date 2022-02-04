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
        $this->view('frontend.products.index');
    }

    public function run()
    {
        echo __METHOD__;
    }

    public function show()
    {
        $this->view('frontend.products.show');
        echo '<br>' . $this->productModel->getAll();
    }
}
