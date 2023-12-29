<?php

session_start();

// Require all PHP files from a directory
$folderList = [
    './config/',
    './app/Core/',
    './lib/',
];
$gfgFolderList = ['Controller' => './app/Controller/'];

foreach ($folderList as $folder) {
    foreach (glob($folder . "*.php") as $filename) {
        if (file_exists($filename)) {
            require $filename;
        }
    }
}

require './app/Model/BaseModel.php';
require './app/Controller/Controller.php';

if (is_dir($gfgFolderList['Controller'])) {
    if ($gfgDir = opendir($gfgFolderList['Controller'])) {
        // Loop through the directory
        while (($gfgSubFolder = readdir($gfgDir)) !== false) {
            $gfgTempPath = $gfgFolderList['Controller'] . $gfgSubFolder . '/';
            if (is_dir($gfgTempPath) && $gfgSubFolder != '.'
                && $gfgSubFolder != '..'
            ) {
                $gfgFolderList[$gfgSubFolder] = $gfgTempPath;
            }
        }
        closedir($gfgDir);
    }
}
// ------------------------------------------------------------------------

// Get Controller
if (isset($_REQUEST['controller']) && '' != $_REQUEST['controller']) {
    $controllerParam = strtolower($_REQUEST['controller']);
}

$controllerNamePrefix = ucfirst($controllerParam ?? '');
$controllerName = $controllerNamePrefix . 'Controller';

foreach ($gfgFolderList as $folder) {
    $fileTemp = $folder . $controllerName . '.php';
    if (class_exists($controllerName)) {
        break;
    } elseif (file_exists($fileTemp)) {
        require $fileTemp;
    }
}
// ------------------------------------------------------------------------

// Get Action
if (isset($_REQUEST['action']) && '' != $_REQUEST['action']) {
    $actionParam = strtolower($_REQUEST['action']);
}
$actionName = $actionParam ?? 'Index';
// ------------------------------------------------------------------------


// 404 page for not found controller
if (!class_exists($controllerName)) {
    $controllerName = 'Controller';
    $actionName = 'NotFound';
}
// ------------------------------------------------------------------------

//Run
$controllerObject = new $controllerName();

if (method_exists($controllerObject, $actionName)) {
    $controllerObject->$actionName();
} else {
    $controllerObject = new Controller();
    $controllerObject->notFound();
}
