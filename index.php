<?php

// include autoloader
require 'vendor/autoload.php';

// create Arrr
$arrr = new \Arrr\Arrr(
    require __DIR__ . '/config/dev.php'
);

// run ...
$arrr->arrr();