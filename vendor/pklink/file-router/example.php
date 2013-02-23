<?php

require __DIR__ . '/vendor/autoload.php';


/********** EXAMPLE FOR INCLUDING PHP FILES **********/

// the source path for including files
$sourcePath = new SplFileInfo(__DIR__ . '/example/php');

// create router
$router = new \FileRouter\Router\Load($sourcePath);

// handle 'hello'-route
$router->handleRoute('hello');

// handle 'hello/world'-route
$router->handleRoute('hello/world');

// handle not existing file/route
try {
    $router->handleRoute('not/existing/file');
} catch (\FileRouter\Exception\Route\DoesNotExist $e) {
    printf('<pre>%s</pre>', $e->getMessage());
}

// handle file outside of the source path
try {
    $router->handleRoute('../../example');
} catch (\FileRouter\Exception\Route\IsNotInSourcePath $e) {
    printf('<pre>%s</pre>', $e->getMessage());
}


/********** EXAMPLE FOR INCLUDING PHP FILES **********/

// the source path for including files
$sourcePath = new SplFileInfo(__DIR__ . '/example/txt');

// create router
$router = new \FileRouter\Router\OutputTxt($sourcePath);

// handle 'hello'-route
$router->handleRoute('hello');

// handle 'hello/world'-route
$router->handleRoute('hello/world');

// handle not existing file/route
try {
    $router->handleRoute('not/existing/file');
} catch (\FileRouter\Exception\Route\DoesNotExist $e) {
    printf('<pre>%s</pre>', $e->getMessage());
}
