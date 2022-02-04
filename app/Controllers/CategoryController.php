<?php

class CategoryController extends Controller
{
    public function index()
    {
        $categories = array(
            1 => 'product 1',
            2 => 'product 2',
            3 => 'product 3',
            4 => 'product 4',
            5 => 'product 5',
        );
        
        $this->view('frontend.categories.index', array(
            'categories' => $categories,
        ));
    }

    public function run()
    {
        echo __METHOD__;
    }
}
