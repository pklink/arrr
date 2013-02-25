<?php

namespace Arrr\Service;

class Chain extends \SplPriorityQueue
{

    /**
     * @var bool
     */
    protected $isStopped = false;


    /**
     * @return void
     */
    protected function restart()
    {
        $this->isStopped = false;
    }


    /**
     * @return void
     */
    public function stop()
    {
        $this->isStopped = true;
    }


    /**
     * @return bool
     */
    public function valid()
    {
        return !$this->isStopped && parent::valid();
    }

}
