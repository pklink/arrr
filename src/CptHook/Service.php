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
     * @return void
     */
    public function run();


    /**
     * @param int $priority
     * @return void
     */
    public function setPriority($priority);

}
