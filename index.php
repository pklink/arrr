<?php

// include autoloader
require 'vendor/autoload.php';

// create app
$cms = new CptHook\CMS([
    'resourcePath' => [
        'content' => __DIR__ . '/res/content', // optionally; this is the default path
        'system'  => __DIR__ . '/res/system',  // optionally; this is the default path
    ],
    'templatePath' => __DIR__ . '/themes/default', // optionally; this is the default path
    'routingParam' => 'r', // optionally; this is the default value
    'debug'        => $_SERVER['REMOTE_ADDR'] == '::1', // optionally; defaul value is false
]);

// run app
$cms->run();