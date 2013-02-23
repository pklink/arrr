<?php

namespace CptHook;

use Symfony\Component\HttpFoundation;


/**
 * @author Pierre Klink
 * @license MIT See LICENSE file for more details
 */
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


    /**
     * Prepare the $cms by the given configuartion
     *
     * @param array $config
     *      string|array resourcePath (default: './res')
     *          string content (default: resourcePath + '/content'
     *          string system  (default: resourcePath + '/system'
     *      string routingParm (default: 'r')
     *      string templatePath (default: './themes/default'
     *      boolean debug (default: false)
     * @param CMS $cms
     */
    public static function arr(array $config = [], CMS $cms)
    {
        self::$givenConfig = new \Dotor\Dotor($config);
        self::$cms         = $cms;

        self::setDebugging();
        self::setRoutingParam();
        self::setRouter();
        self::setTwig();
        self::setRequest();
    }


    /**
     * Set app in debugging mode if debbuging=true
     */
    private static function setDebugging()
    {
        if (self::$givenConfig->get('debug', false))
        {
            // transform errors to exceptions
            \Eloquent\Asplode\Asplode::instance()->install();

            // sett exception handler
            set_exception_handler(array(
                new \Exceptionist\DefaultExceptionHandler(),
                'handle'
            ));
        }

    }



    /**
     * Create HttpFoundation\Request and set it to CMS
     */
    private static function setRequest()
    {
        self::$cms->setRequest(HttpFoundation\Request::createFromGlobals());
    }


    /**
     * Set the routing param to CMS
     */
    private static function setRoutingParam()
    {
        $routingParam = self::$givenConfig->getScalar('routingParam', 'r');
        self::$cms->setRoutingParam($routingParam);
    }


    /**
     * Create system router and content router and set them in CMS
     */
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


    /**
     * Create Twig and set it to CMS
     */
    private static function setTwig()
    {
        $templatePath = self::$givenConfig->getScalar('templatePath', realpath(__DIR__ . '/../../themes/default'));
        $loader       = new \Twig_Loader_Filesystem($templatePath);

        self::$cms->setTwig(new \Twig_Environment($loader));
    }

}
