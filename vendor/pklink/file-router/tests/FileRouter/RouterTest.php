<?php

namespace FileRouter;

class RouterTest extends \PHPUnit_Framework_TestCase
{

    public function testIsInterface()
    {
        $reflection = new \ReflectionClass('\FileRouter\Router');
        $this->assertTrue($reflection->isInterface());
    }

}
