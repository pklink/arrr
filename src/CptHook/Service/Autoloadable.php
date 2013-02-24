<?php

namespace CptHook\Service;

interface Autoloadable extends \CptHook\Service
{

    /**
     * @return string
     */
    public function getDefaultParam();

}