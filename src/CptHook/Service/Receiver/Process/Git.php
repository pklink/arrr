<?php

namespace CptHook\Service\Receiver\Process;

use \Symfony\Component\Process\Process;

class Git implements \CptHook\Service\Receiver\Process
{

    public function run()
    {
        $process = new Process('ls');
        $process->run();
        echo $process->getOutput();
    }

}
