<?php

namespace Arrr\Service\Receiver\Process;

use \Symfony\Component\Process\Process;

class Git implements \Arrr\Service\Receiver\Process
{

    public function run()
    {
        $process = new Process('ls');
        $process->run();
        echo $process->getOutput();
    }

}
