<?php
session_start();

// Require all PHP files from a directory
$folderList = array(
    './config/',
    './app/core/',
    './lib/',
);
foreach ($folderList as $folder) {
    foreach (glob($folder . "*.php") as $filename) {
        if (file_exists($filename)) {
            require $filename;
        }
    }
}

require './app/models/BaseModel.php';

spl_autoload_register(function ($className) {
    if (file_exists('./app/controllers/' . $className . '.php')) {
        require './app/controllers/' . $className . '.php';
    }
});

//Controller
if (isset($_REQUEST['controller']) && '' != $_REQUEST['controller']) {
    $controllerParam = strtolower($_REQUEST['controller']);
}
$controllerName = ucfirst(($controllerParam ?? '') . 'Controller');
require "./app/controllers/${controllerName}.php";

//Action
if (isset($_REQUEST['action']) && '' != $_REQUEST['action']) {
    $actionParam = strtolower($_REQUEST['action']);
}
$actionName = $actionParam ?? 'Index';

//Run
$controllerObject = new $controllerName();
$controllerObject->$actionName();