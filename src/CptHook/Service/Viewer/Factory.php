<?php

namespace CptHook\Service\Viewer;

use Symfony\Component\HttpFoundation;


/**
 * @author Pierre Klink
 * @license MIT See LICENSE file for more details
 */
class Factory implements \CptHook\Service\Factory
{

    /**
     * @var \Dotor\Dotor
     */
    private static $givenConfig;


    /**
     * @var \CptHook\Service\Viewer
     */
    private static $viewer;


    /**
     * Create and prepare a instance of \CptHook\Service\Viewer
     *
     * @param array $config
     *      integer priority (default: 50)
     *      string|array resourcePath (default: './res')
     *          string content (default: resourcePath + '/content'
     *          string system  (default: resourcePath + '/system'
     *      string routingParm (default: 'r')
     *      string templatePath (default: './themes/default'
     * @return \CptHook\Service\Viewer
     */
    public static function create(array $config = [])
    {
        self::$givenConfig = new \Dotor\Dotor($config);
        self::$viewer      = new \CptHook\Service\Viewer();

        self::setRoutingParam();
        self::setRouter();
        self::setTwig();
        self::setPriority();

        return self::$viewer;
    }


    private static function setPriority()
    {
        $priority = self::$givenConfig->getScalar('priority', 50);
        self::$viewer->setPriority($priority);
    }


    private static function setRoutingParam()
    {
        $routingParam = self::$givenConfig->getScalar('routingParam', 'r');
        self::$viewer->setRoutingParam($routingParam);
    }


    private static function setRouter()
    {
        $resourcePath = self::$givenConfig->getScalar('resourcePath', realpath(__DIR__ . '/../../res'));
        $contentPath  = self::$givenConfig->getScalar('resourcePath.content', $resourcePath . '/content');
        $systemPath   = self::$givenConfig->getScalar('resourcePath.system', $resourcePath . '/system');

        $contentPath = new \SplFileInfo($contentPath);
        $systemPath  = new \SplFileInfo($systemPath);

        self::$viewer->setContentRouter(new \CptHook\Service\Viewer\Router($contentPath));
        self::$viewer->setSystemRouter(new \CptHook\Service\Viewer\Router($systemPath));
    }


    private static function setTwig()
    {
        $templatePath = self::$givenConfig->getScalar('templatePath', realpath(__DIR__ . '/../../themes'));
        $theme        = self::$givenConfig->getScalar('theme', 'default');
        $loader       = new \Twig_Loader_Filesystem(sprintf('%s/%s', $templatePath, $theme));

        self::$viewer->setTwig(new \Twig_Environment($loader));
    }

}
