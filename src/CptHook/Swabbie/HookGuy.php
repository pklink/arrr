<?php

namespace CptHook\Swabbie;

class HookGuy implements \CptHook\Swabbie
{


    /**
     * @var \Dotor\Dotor
     */
    protected static $givenConfig;


    /**
     * @var \CptHook\Hook
     */
    protected static $hook;


    /**
     * @param array $config
     * @param \CptHook\Hook $hook
     * @throws \InvalidArgumentException
     */
    public static function yarrr(array $config = [], $hook)
    {
        if (!($hook instanceof \CptHook\Hook))
        {
            throw new \InvalidArgumentException('$hook must be an instance of \CptHook\Hook');
        }

        self::$givenConfig = new \Dotor\Dotor($config);
        self::$hook        = $hook;

        self::setParam();
        self::setProcess();
    }


    private static function setParam()
    {
        $param = self::$givenConfig->get('param');
        self::$hook->setParam($param);
    }


    private static function setProcess()
    {
        $command = 'ls';

        self::$hook->setProcess(new \Symfony\Component\Process\Process($command));
    }


}
