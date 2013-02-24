<?php

namespace CptHook\Service;

interface Factory
{

    /**
     * @param array $config
     * @return \CptHook\Service
     */
    public static function create(array $config = []);

}
