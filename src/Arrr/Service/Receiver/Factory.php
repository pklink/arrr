<?php

namespace Arrr\Service\Receiver;

use Arrr\Service;

class Factory implements \Arrr\Service\Factory
{

    /**
     * @var \Dotor\Dotor
     */
    protected static $givenConfig;


    /**
     * @var \Arrr\Service\Receiver
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


    private static function setPriority()
    {
        $priority = self::$givenConfig->get('priority', 100);
        self::$receiver->setPriority($priority);
    }


    private static function setProcess()
    {
        self::$receiver->setProcess(new \Arrr\Service\Receiver\Process\Git());
    }


}
