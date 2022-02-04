<?php

class Controller
{
    const VIEW_PATH = 'app/Views';

    /**
     * index
     */
    public function index()
    {
        self::view('frontend.index');
    }

    /**
     * Path name - get after View folder
     * @param $viewPath
     */
    protected function view($viewPath)
    {
        $viewPath = self::VIEW_PATH . '/' . str_replace('.', '/', $viewPath) . '.php';
        return require $viewPath;
    }
}
