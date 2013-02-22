<?php

namespace CptHook;

use FileRouter\Router\AbstractImpl;
use dflydev\markdown\MarkdownParser;

class Router extends AbstractImpl
{

    /**
     * @var MarkdownParser
     */
    protected $markdownParser;


    /**
     * @param \SplFileInfo $sourcePath
     */
    function __construct(\SplFileInfo $sourcePath)
    {
        $this->markdownParser = new MarkdownParser();
        parent::__construct($sourcePath, 'md');
    }


    /**
     * Handle the given $route.
     *
     * @param string $route
     * @return string
     */
    public function handleRoute($route)
    {
        $file = $this->getFileByRoute($route);

        return $this->markdownParser->transformMarkdown( file_get_contents($file->getRealPath()) );
    }


}
