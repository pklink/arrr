<?php

// include autoloader
require 'vendor/autoload.php';

// create app
\CptHook\CMS::init([
    'resourcePath' => [
        'content' => __DIR__ . '/res/content', // optionally; this is the default path
        'system'  => __DIR__ . '/res/system',  // optionally; this is the default path
    ],
    'templatePath' => __DIR__ . '/themes', // optionally; this is the default path
    'theme'        => 'default', // // optionally; this is the default value
    'routingParam' => 'r', // optionally; this is the default value
    'debug'        => $_SERVER['REMOTE_ADDR'] == '::1', // optionally; defaul value is false
    'hook'         => [
        'param' => null, // optionally; null means hooks are disabled
                         // if you like to use hooks set this param to
                         // a hard to guess string with minimum length
                         // of 12 characters
    ]
]);


// run CMS
\CptHook\CMS::instance()->run();