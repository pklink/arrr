<?php

// include autoloader
require 'vendor/autoload.php';

// create app
$sir = new \CptHook\Sir([
    'viewer' => [
        'priority'     => 50,
        'resourcePath' => [
            'content' => __DIR__ . '/res/content', // optionally; this is the default path
            'system'  => __DIR__ . '/res/system',  // optionally; this is the default path
        ],
        'templatePath' => __DIR__ . '/themes', // optionally; this is the default path
        'theme'        => 'default', // // optionally; this is the default value
        'routingParam' => 'r', // optionally; this is the default value
        'debug'        => $_SERVER['REMOTE_ADDR'] == '::1', // optionally; defaul value is false
    ],
    'receiver' => [
        'routingParam' => null, // optionally; null means updates are disabled
                         // if you like to use updates set this option to a hard to guess string
                         // with minimum length of 12 characters
        // TODO: implement process
        'process' => 'Git' // optionally; this is the default value
    ]
]);


// run CMS
$sir->yarrr();