<?php

namespace CptHook;

use \Symfony\Component\Process\Process;

class Hook
{

    /**
     * @var string
     */
    protected $param;


    /**
     * @var Process
     */
    protected $process;


    /**
     * @param array $config
     */
    public function __construct(array $config = [])
    {
        Swabbie\HookGuy::yarrr($config, $this);
    }


    /**
     * @return string
     */
    public function getParam()
    {
        return $this->param;
    }


    /**
     * @return Process
     */
    public function getProcess()
    {
        return $this->process;
    }


    /**
     * @param string $param
     * @throws \InvalidArgumentException
     */
    public function setParam($param)
    {
        // check if $param is a string
        if (!is_string($param))
        {
            throw new \InvalidArgumentException('$param has to be a string');
        }

        // check if the length if $param is minimum 12
        if (strlen($param) < 12)
        {
            throw new \InvalidArgumentException('$param needs to have a minimum-length of 12 characters');
        }

        $this->param = $param;
    }


    /**
     * @param Process $process
     */
    public function setProcess(Process $process)
    {
        $this->process = $process;
    }

}
