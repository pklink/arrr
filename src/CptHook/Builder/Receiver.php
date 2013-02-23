<?php

namespace CptHook\Builder;

class Receiver implements \CptHook\Builder
{

    /**
     * @var \Dotor\Dotor
     */
    protected static $givenConfig;


    /**
     * @var \CptHook\Receiver
     */
    protected static $receiver;


    /**
     * @param array $config
     * @param \CptHook\Receiver $receiver
     * @throws \InvalidArgumentException
     */
    public static function build(array $config = [], $receiver)
    {
        if (!($receiver instanceof \CptHook\Receiver))
        {
            throw new \InvalidArgumentException('$receiver has to be an instance of \CptHook\Hook');
        }

        self::$givenConfig = new \Dotor\Dotor($config);
        self::$receiver    = $receiver;

        self::setRoutingParam();
        self::setProcess();
    }


    private static function setRoutingParam()
    {
        $param = self::$givenConfig->get('routingParam');
        self::$receiver->setRoutingParam($param);
    }


    private static function setProcess()
    {
        self::$receiver->setProcess(new \CptHook\Process\Git());
    }


}
