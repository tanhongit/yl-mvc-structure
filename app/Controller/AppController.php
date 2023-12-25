<?php

class AppController extends Controller
{
    public function index(): void
    {
        echo __METHOD__;
    }

    public function run(): void
    {
        echo __METHOD__;
    }

    public function header(): void
    {
        $this->renderView('frontend.partial.header');
    }

    public function footer(): void
    {
        $this->renderView('frontend.partial.footer');
    }
}
