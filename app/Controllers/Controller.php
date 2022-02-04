<?php

class Controller
{
    const VIEW_PATH = 'app/views';
    const MODEL_PATH = 'app/models';
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
     * @param array $data
     */
    protected function view($viewPath, array $data = [])
    {
        //get data
        foreach ($data as $key => $value) {
            $$key = $value;
        }

        $viewPathFile = self::VIEW_PATH . '/' . str_replace('.', '/', $viewPath) . '.php';
        require $viewPathFile;
    }

    protected function loadModel($modelPath)
    {
        $modelPathFile = self::MODEL_PATH . '/' . str_replace('.', '/', $modelPath) . '.php';
        require $modelPathFile;
    }
}
