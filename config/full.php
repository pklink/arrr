<?php

$viewer   = require __DIR__ . '/viewer.php';
$receiver = require __DIR__ . '/receiver.php';

return [
    'debug'    => false,                 // optionally, defaul: false
    'webroot'  => __DIR__. '/..',        // optionally, Arrr will use the directory path of this file
    'viewer'   => $viewer['viewer'],     // see ./viewer.php
    'receiver' => $receiver['receiver'], // see ./receiver.php
    'services' => ['viewer', 'receiver'] // required
];
