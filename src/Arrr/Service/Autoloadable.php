<?php

namespace Arrr\Service;

interface Autoloadable extends \Arrr\Service
{

    /**
     * @return string
     */
    public function getDefaultParam();

}