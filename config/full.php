<?php

return [
    'debug'    => true,
    'webroot'  => __DIR__,   // optionally, Arrr will use the directory path of this file
    'viewer' => [
        'enabled'      => true, // optionally; true is the default value
        'factory'      => ['\Arrr\Service\Viewer\Factory', 'create'], // required; name of class and method
        'resourcePath' => [
            'content' => __DIR__ . '/../res/content', // optionally; this is the default path
            'system'  => __DIR__ . '/../res/system',  // optionally; this is the default path
        ],
        'routingParam' => 'r',                 // optionally; this is the default value
        'templatePath' => __DIR__ . '/../themes', // optionally; this is the default path
        'theme'        => 'default',           // optionally; this is the default value
        'priority'     => 50,                  // optionally; this is the default value
    ],
    'receiver' => [
        'enabled'      => false, // optionally; true is the default value
        'factory'      => ['\Arrr\Service\Receiver\Factory', 'create'], // optionally; this is the default value
        //'routingParam' => 'nSgBwtF2d6MgjH5pRc',
        'routingParam' => null, // required if 'enabled' is true; string with minimum length of 12 characters
        // TODO: implement process
        'process'  => 'Git', // optionally; this is the default value
        'priority' => 100,   // optionally; this is the default value
    ],
    'services' => ['viewer', 'receiver']
];
