<?php

class Controller
{
    const VIEW_PATH = 'resources/views';
    const MODEL_PATH = 'app/Model';

    /**
     * Index
     *
     * @return void
     */
    public function index()
    {
        $this->renderView('frontend.index');
    }

    /**
     * Path name - get after View folder
     *
     * @param $viewPath
     * @param array $data
     */
    public function renderView($viewPath, array $data = [])
    {
        $this->renderPartial('frontend.partial.header');
        $this->renderPartial($viewPath, $data);
        $this->renderPartial('frontend.partial.footer');
    }

    /**
     * Render partial file
     *
     * @param $partialPath
     * @param array $data
     */
    public function renderPartial($partialPath, array $data = [])
    {
        //get data
        foreach ($data as $key => $value) {
            $$key = $value;
        }

        $viewPathFile = self::VIEW_PATH . '/' . str_replace('.', '/',
                $partialPath) . '.php';
        require $viewPathFile;
    }

    /**
     * Load model
     *
     * @param $modelPath
     *
     * @return void
     */
    protected function loadModel($modelPath)
    {
        $modelPathFile = self::MODEL_PATH . '/' . str_replace('.', '/',
                $modelPath) . '.php';
        require $modelPathFile;
    }

    /**
     * Redirect to 404 page
     *
     * @return void
     */
    public function notFound()
    {
        $this->renderView('frontend.error.pages.404');
    }
}
