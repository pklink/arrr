<?php

// include autoloader
require 'vendor/autoload.php';

// create app
$sir = new \CptHook\Sir([
    'debug'    => true,
    'webroot'  => __DIR__,   // optionally, Sir will use the directory path of this file
    'services' => [
        'viewer'   => '\CptHook\Service\Viewer\Factory', // <index in config> => <name of Service-Factory>
        'receiver' => '\CptHook\Service\Receiver\Factory'
    ],                       // optionally, this is the default value
    'viewer' => [
        'enabled'      => true, // optionally; true is the default value
        'resourcePath' => [
            'content' => __DIR__ . '/res/content', // optionally; this is the default path
            'system'  => __DIR__ . '/res/system',  // optionally; this is the default path
        ],
        'routingParam' => 'r',                 // optionally; this is the default value
        'templatePath' => __DIR__ . '/themes', // optionally; this is the default path
        'theme'        => 'default',           // optionally; this is the default value
        'priority'     => 50,                  // optionally; this is the default value
    ],
    'receiver' => [
        'enabled'      => false, // optionally; true is the default value
        //'routingParam' => 'nSgBwtF2d6MgjH5pRc',
        'routingParam' => null, // required if 'enabled' is true; string with minimum length of 12 characters
        // TODO: implement process
        'process'  => 'Git', // optionally; this is the default value
        'priority' => 100,   // optionally; this is the default value
    ]
]);

// run CMS
$sir->arrr();