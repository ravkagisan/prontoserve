<?php
$request_uri = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
$request_uri = rtrim($request_uri, '/');

if ($request_uri === '' || $request_uri === '/index.php') {
    require __DIR__ . '/../Pages/index.php';
    exit;
}

$target_file = __DIR__ . '/..' . $request_uri;

if (file_exists($target_file) && !is_dir($target_file)) {
    require $target_file;
    exit;
}

if (file_exists($target_file . '/index.php')) {
    require $target_file . '/index.php';
    exit;
}

http_response_code(404);
require __DIR__ . '/../error/index.php';
exit;
