<?php

namespace Arrr\Service;

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
     * @throws \UnexpectedValueException
     */
    public function setPriority($priority)
    {
        if (!is_int($priority))
        {
            throw new \UnexpectedValueException('$priority has to be an integer');
        }

        $this->priority = $priority;
    }

}
