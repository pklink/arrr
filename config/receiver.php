<?php


return [
    'debug'    => false,
    'webroot'  => __DIR__ . '/..',   // optionally, Arrr will use the directory path of this file
    'receiver' => [
        'enabled'      => false, // optionally; true is the default value
        'factory'      => ['\Arrr\Service\Receiver\Factory', 'create'], // optionally; this is the default value
        //'routingParam' => 'nSgBwtF2d6MgjH5pRc',
        'routingParam' => null, // required if 'enabled' is true; string with minimum length of 12 characters
        // TODO: implement process
        'process'  => 'Git', // optionally; this is the default value
        'priority' => 100,   // optionally; this is the default value
    ],
    'services' => ['receiver']
];