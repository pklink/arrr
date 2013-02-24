<?php

namespace CptHook\Service\Receiver;

use CptHook\Service;

class Factory implements \CptHook\Service\Factory
{

    /**
     * @var \Dotor\Dotor
     */
    protected static $givenConfig;


    /**
     * @var \CptHook\Service\Receiver
     */
    protected static $receiver;


    /**
     * @param array $config
     * @return Service\Receiver
     */
    public static function create(array $config = [])
    {
        self::$givenConfig = new \Dotor\Dotor($config);
        self::$receiver    = new Service\Receiver();

        self::setRoutingParam();
        self::setProcess();
        self::setPriority();

        return self::$receiver;
    }


    private static function setRoutingParam()
    {
        $param = self::$givenConfig->get('routingParam');
        self::$receiver->setRoutingParam($param);
    }


    private function setPriority()
    {
        self::$receiver->setPriority(100);
    }


    private static function setProcess()
    {
        self::$receiver->setProcess(new \CptHook\Service\Receiver\Process\Git());
    }


}
