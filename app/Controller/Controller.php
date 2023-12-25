<?php

class Controller
{
    protected const VIEW_PATH = 'resources' . DIRECTORY_SEPARATOR . 'views';
    protected const MODEL_PATH = 'app' . DIRECTORY_SEPARATOR . 'Model';

    /**
     * Index
     *
     * @return void
     */
    public function index(): void
    {
        $this->renderView('frontend.index');
    }

    /**
     * Path name - get after View folder
     *
     * @param $viewPath
     * @param array $data
     */
    public function renderView($viewPath, array $data = []): void
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
    public function renderPartial($partialPath, array $data = []): void
    {
        //get data
        foreach ($data as $key => $value) {
            $$key = $value;
        }

        $viewPathFile = self::VIEW_PATH . DIRECTORY_SEPARATOR
            . str_replace('.', DIRECTORY_SEPARATOR, $partialPath) . '.php';
        require $viewPathFile;
    }

    /**
     * Load model
     *
     * @param $modelPath
     *
     * @return void
     */
    protected function loadModel($modelPath): void
    {
        $modelPathFile = self::MODEL_PATH . DIRECTORY_SEPARATOR
            . str_replace('.', DIRECTORY_SEPARATOR, $modelPath) . '.php';
        require $modelPathFile;
    }

    /**
     * Redirect to 404 page
     *
     * @return void
     */
    public function notFound(): void
    {
        $this->renderView('frontend.error.pages.404');
    }
}
