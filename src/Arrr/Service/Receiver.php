<?php

namespace Arrr\Service;

use Arrr\Service\Receiver\Process;

class Receiver extends AbstractImpl implements \Arrr\Service
{

    /**
     * @var string
     */
    protected $routingParam;


    /**
     * @var Process
     */
    protected $process;


    /**
     * @return string
     */
    public function getRoutingParam()
    {
        return $this->routingParam;
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
     * @param Chain $serviceChain
     */
    public function run($param, Chain $serviceChain)
    {
        $this->process->run();
    }


    /**
     * @param string $param
     * @throws \UnexpectedValueException
     * @throws \InvalidArgumentException
     */
    public function setRoutingParam($param)
    {
        // check if $param is a string
        if (!is_string($param))
        {
            throw new \UnexpectedValueException('$param has to be a string');
        }

        // check if the length if $param is minimum 12
        if (strlen($param) < 12)
        {
            throw new \InvalidArgumentException('$param needs to have a minimum-length of 12 characters');
        }

        $this->routingParam = $param;
    }


    /**
     * @param Process $process
     */
    public function setProcess(Process $process)
    {
        $this->process = $process;
    }

}
