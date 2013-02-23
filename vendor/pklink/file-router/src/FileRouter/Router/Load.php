<?php

namespace FileRouter\Router;

/**
 * Include PHP files in the given source path
 *
 * @author Pierre Klink <dev@klinks.info>
 * @license MIT See LICENSE file for more information
 */
class Load extends AbstractImpl
{

    /**
     * Create instance with source path and "php" as fileExtension
     *
     * @param \SplFileInfo $sourcePath
     */
    function __construct(\SplFileInfo $sourcePath)
    {
        parent::__construct($sourcePath, 'php');
    }


    /**
     * Handle the route $route
     *
     * @param string $route
     * @return void
     */
    public function handleRoute($route)
    {
        $requestedFile = $this->getFileByRoute($route);
        include $requestedFile->getRealPath();
    }

}
