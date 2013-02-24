<?php

namespace CptHook\Service;

class AbstractImpl
{

    /**
     * @var int
     */
    protected $priority = 100;


    /**
     * @return int
     */
    public function getPriority()
    {
        return $this->priority;
    }


    /**
     * @param int $priority
     */
    public function setPriority($priority)
    {
        $this->priority = $priority;
    }

}
