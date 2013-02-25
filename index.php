<?php

// include autoloader
require 'vendor/autoload.php';

// create Arrr
$arrr = new \Arrr\Arrr(
    require __DIR__ . '/config/full.php'
);

// run ...
$arrr->arrr();