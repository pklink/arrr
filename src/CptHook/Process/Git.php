<?php

namespace CptHook\Process;

use \Symfony\Component\Process\Process;

class Git implements \CptHook\Process
{

    public function run()
    {
        $process = new Process('ls');
        $process->run();
    }

}
