<?php

namespace Arrr;

interface Service
{

    /**
     * @return string
     */
    public function getRoutingParam();


    /**
     * @return int
     */
    public function getPriority();


    /**
     * @param $param
     * @param Service\Chain $serviceChain
     * @return void
     */
    public function run($param, Service\Chain $serviceChain);


    /**
     * @param int $priority
     * @return void
     */
    public function setPriority($priority);

}
