<?php
session_start();

// Require all PHP files from a directory
$folderList = array(
    './config/',
    './app/core/',
    './lib/',
);
$gfgFolderList = ['Controller' => './app/controllers/'];

foreach ($folderList as $folder) {
    foreach (glob($folder . "*.php") as $filename) {
        if (file_exists($filename)) {
            require $filename;
        }
    }
}

require './app/models/BaseModel.php';

if (is_dir($gfgFolderList['Controller'])) {
    if ($gfgDir = opendir($gfgFolderList['Controller'])) {
        // Loop through the directory
        while (($gfgSubFolder = readdir($gfgDir)) !== false) {
            $gfgTempPath = $gfgFolderList['Controller'] . $gfgSubFolder . '/';
            if (is_dir($gfgTempPath) && $gfgSubFolder != '.' && $gfgSubFolder != '..') {
                $gfgFolderList[$gfgSubFolder] = $gfgTempPath;
            }
        }
        closedir($gfgDir);
    }
}

// Require all PHP files from directory and subdirectory
foreach ($gfgFolderList as $folder) {
    spl_autoload_register(function ($className) use ($folder) {
        $fileTemp = $folder . '/' . $className . '.php';
        if (file_exists($folder . $className . '.php')) {
            require $folder . $className . '.php';
        }
    });
}

//Controller
if (isset($_REQUEST['controller']) && '' != $_REQUEST['controller']) {
    $controllerParam = strtolower($_REQUEST['controller']);
}

$controllerNamePrefix = ucfirst($controllerParam ?? '');
$controllerName = $controllerNamePrefix . 'Controller';

require $gfgFolderList[$controllerNamePrefix] . $controllerName . '.php';

//Action
if (isset($_REQUEST['action']) && '' != $_REQUEST['action']) {
    $actionParam = strtolower($_REQUEST['action']);
}
$actionName = $actionParam ?? 'Index';

//Run
$controllerObject = new $controllerName();
$controllerObject->$actionName();