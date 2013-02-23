<?php

namespace CptHook\Swabbie;

use Symfony\Component\HttpFoundation;
use CptHook\Router;


/**
 * @author Pierre Klink
 * @license MIT See LICENSE file for more details
 */
class CMSGuy implements \CptHook\Swabbie
{

    /**
     * @var \Dotor\Dotor
     */
    private static $givenConfig;


    /**
     * @var \CptHook\CMS
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
     * @param \CptHook\CMS $cms
     * @throws \InvalidArgumentException
     */
    public static function yarrr(array $config = [], $cms)
    {
        if (!($cms instanceof \CptHook\CMS))
        {
            throw new \InvalidArgumentException('$cms has to be an instance of \CptHook\CMS');
        }

        self::$givenConfig = new \Dotor\Dotor($config);
        self::$cms         = $cms;

        self::setDebugging();
        self::setRoutingParam();
        self::setRouter();
        self::setTwig();
        self::setRequest();
        self::setHook();
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
     * Set Hook if hook.param is set
     */
    private static function setHook()
    {
        $param = self::$givenConfig->get('hook.param');

        if ($param !== null)
        {
            $config = self::$givenConfig->get('hook');
            self::$cms->setHook(new \CptHook\Hook($config));
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
        $contentPath  = self::$givenConfig->getScalar('resourcePath.content', $resourcePath . '/content');
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
        $templatePath = self::$givenConfig->getScalar('templatePath', realpath(__DIR__ . '/../../themes'));
        $theme        = self::$givenConfig->getScalar('theme', 'default');
        $loader       = new \Twig_Loader_Filesystem(sprintf('%s/%s', $templatePath, $theme));

        self::$cms->setTwig(new \Twig_Environment($loader));
    }

}
