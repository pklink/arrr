<?php

namespace Arrr\Service;

interface Factory
{

    /**
     * @param array $config
     * @return \Arrr\Service
     */
    public static function create(array $config = []);

}
