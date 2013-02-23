<?php

namespace CptHook;

class Mark
{

    /**
     * @var \Dotor\Dotor
     */
    private static $givenConfig;


    /**
     * @var CMS
     */
    private static $cms;


    private static function setRoutingParam()
    {
        $routingParam = self::$givenConfig->getScalar('routingParam', 'r');

        if (isset($config['routingParam']))
        {
            self::$cms->setRoutingParam($routingParam);
        }
    }

    private static function setRouter()
    {
        $resourcePath = self::$givenConfig->getScalar('resourcePath', realpath(__DIR__ . '/../../res'));
        $contentPath  = self::$givenConfig->getScalar('resourcePath.public', $resourcePath . '/content');
        $systemPath   = self::$givenConfig->getScalar('resourcePath.system', $resourcePath . '/system');

        $contentPath = new \SplFileInfo($contentPath);
        $systemPath  = new \SplFileInfo($systemPath);

        self::$cms->setContentRouter(new Router($contentPath));
        self::$cms->setSystemRouter(new Router($systemPath));
    }

    private static function setTwig()
    {
        $templatePath = self::$givenConfig->getScalar('templatePath', realpath(__DIR__ . '/../../themes/default'));
        $loader       = new \Twig_Loader_Filesystem($templatePath);

        self::$cms->setTwig(new \Twig_Environment($loader));
    }


    private static function setRequest()
    {
        self::$cms->setRequest(\Symfony\Component\HttpFoundation\Request::createFromGlobals());
    }


    public static function arr(array $config = array(), CMS $cms)
    {
        self::$givenConfig = new \Dotor\Dotor($config);
        self::$cms         = $cms;

        self::setRoutingParam();
        self::setRouter();
        self::setTwig();
        self::setRequest();
    }

}
