<?php

namespace CptHook;

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
     * @param string $param
     * @return void
     */
    public function run($param);


    /**
     * @param int $priority
     * @return void
     */
    public function setPriority($priority);

}
