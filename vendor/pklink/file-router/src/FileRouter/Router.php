<?php

namespace FileRouter;

/**
 * @author Pierre Klink <dev@klinks.info>
 * @license MIT See LICENSE file for more information
 */
interface Router
{

    /**
     * Get the setted file extension
     *
     * @return string
     */
    public function getFileExtension();


    /**
     * Get the setted source path.
     *
     * @return \SplFileInfo
     */
    public function getSourcePath();


    /**
     * Handle the given $route.
     *
     * @param string $route
     * @return void
     */
    public function handleRoute($route);


    /**
     * Set the file extension.
     * Only files with this extension are relevant for routing
     *
     * @param string $extension
     * @return void
     */
    public function setFileExtension($extension = 'php');


    /**
     * Set the source path.
     * Only files in this path are relevant for routing
     *
     * @param \SplFileInfo $sourcePath
     * @return void
     */
    public function setSourcePath(\SplFileInfo $sourcePath);

}
