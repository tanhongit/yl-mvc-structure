<?php

class ProductController extends Controller
{
    public function index()
    {
        $this->view('frontend.products.index');
    }

    public function run()
    {
        echo __METHOD__;
    }
}
