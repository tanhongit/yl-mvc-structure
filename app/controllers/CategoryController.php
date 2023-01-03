<?php

class CategoryController extends Controller
{
    private $categoryModel;

    public function __construct()
    {
        $this->loadModel('CategoryModel');
        $this->categoryModel = new CategoryModel;
    }

    public function index()
    {
        $categories = array(
            1 => 'product 1',
            2 => 'product 2',
            3 => 'product 3',
            4 => 'product 4',
            5 => 'product 5',
        );

        $this->renderView('frontend.categories.index', array(
            'categories' => $categories,
        ));
    }

    /**
     * @return string
     */
    public function run(): string
    {
        return __METHOD__;
    }

    public function all()
    {
        $this->renderView('frontend.products.all');
        var_dump($this->categoryModel->getAll());
    }
}
