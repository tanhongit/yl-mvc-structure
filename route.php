<?php

$request = $_SERVER['REQUEST_URI'];
if (file_exists(__DIR__ . $request)) {
    return false;
} else {
    if (preg_match('/^\/([^\/]+)\/([^\/]+)\/([^\/]+)$/', $request, $matches)) {
        $_GET['controller'] = $_REQUEST['controller'] = $matches[1];
        $_GET['action'] = $_REQUEST['action'] = $matches[2];
        $_GET['id'] = $_REQUEST['id'] = $matches[3];
        include __DIR__ . '/index.php';
    } elseif (preg_match('/^\/([^\/]+)\/([^\/]+)$/', $request, $matches)) {
        $_GET['controller'] = $_REQUEST['controller'] = $matches[1];
        $_GET['action'] = $_REQUEST['action'] = $matches[2];
        include __DIR__ . '/index.php';
    } elseif (preg_match('/^\/([^\/]+)$/', $request, $matches)) {
        $_GET['controller'] = $_REQUEST['controller'] = $matches[1];
        include __DIR__ . '/index.php';
    } else {
        header("HTTP/1.0 404 Not Found");
        echo '404 Not Found';
    }
}
