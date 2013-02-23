<?php

namespace FileRouter\Router;

class AbstractImplTest extends \PHPUnit_Framework_TestCase
{

    public function testIsAbstract()
    {
        $reflection = new \ReflectionClass('\FileRouter\Router\AbstractImpl');
        $this->assertTrue($reflection->isAbstract());
    }

}
