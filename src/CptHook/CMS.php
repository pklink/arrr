<?php

namespace CptHook;

use Symfony\Component\HttpFoundation;
use CptHook\Builder;


/**
 * @author Pierre Klink
 * @license MIT See LICENSE file for more details
 */
class CMS
{

    /**
     * @var Router
     */
    protected $contentRouter;


    /**
     * @var Receiver
     */
    protected $receiver;


    /**
     * @var CMS
     */
    protected static $instance;


    /**
     * @var Router
     */
    protected $systemRouter;


    /**
     * Helper for accessing to the request
     *
     * @var HttpFoundation\Request
     */
    protected $request;


    /**
     * The template engine
     *
     * @var \Twig_Environment
     */
    protected $twig;


    /**
     * The routing parameter.
     * Routes will be defined by $_REQUEST[$this->routingParam]
     *
     * @var string
     */
    protected $routingParam = 'r';


    /**
     * @param array $config
     */
    protected function __construct(array $config = [])
    {
        Builder\CMS::build($config, $this);
    }


    /**
     * @return Receiver
     */
    public function getReceiver()
    {
        return $this->receiver;
    }


    /**
     * @return HttpFoundation\Request
     */
    public function getRequest()
    {
        return $this->request;
    }


    /**
     * @return Router
     */
    public function getContentRouter()
    {
        return $this->contentRouter;
    }


    /**
     * @return string
     */
    public function getRoutingParam()
    {
        return $this->routingParam;
    }


    /**
     * @return Router
     */
    public function getSystemRouter()
    {
        return $this->systemRouter;
    }


    /**
     * @return \Twig_Environment
     */
    public function getTwig()
    {
        return $this->twig;
    }


    /**
     * @param array $config
     */
    public static function init(array $config = [])
    {
        self::$instance = new CMS($config);
    }


    /**
     * @return CMS
     */
    public static function instance()
    {
        if (!(self::$instance instanceof CMS))
        {
            self::init();
        }

        return self::$instance;
    }


    /**
     * @return void
     */
    public function run()
    {
        if (($this->receiver instanceof Receiver) &&
            $this->request->get($this->receiver->getRoutingParam()) !== null
        ) {
            $this->receiver->run();
            return;
        }

        // get contentRouter
        $route = $this->request->get($this->routingParam, 'home');

        // handle contentRouter
        try {
            $content = $this->contentRouter->handleRoute($route);

        // route does not exist -> 404
        } catch (\FileRouter\Exception\Route\DoesNotExist $e) {
            $content = $this->systemRouter->handleRoute('404');

        // other exception
        } catch (\Exception $e) {
            // do something
            $content = $this->systemRouter->handleRoute('404');
        }


        // render template
        echo $this->twig->render('index.twig', array(
            'title'      => $this->systemRouter->handleRoute('title'),
            'footer'     => $this->systemRouter->handleRoute('footer'),
            'navigation' => $this->systemRouter->handleRoute('navigation'),
            'content'    => $content,
        ));
    }


    /**
     * @param Router $router
     */
    public function setContentRouter(\CptHook\Router $router)
    {
        $this->contentRouter = $router;
    }


    /**
     * @param Receiver $receiver
     */
    public function setReceiver(Receiver $receiver)
    {
        $this->receiver = $receiver;
    }


    /**
     * @param HttpFoundation\Request $request
     */
    public function setRequest(HttpFoundation\Request $request)
    {
        $this->request = $request;
    }


    /**
     * @param $routingParam
     * @throws \InvalidArgumentException
     */
    public function setRoutingParam($routingParam)
    {
        if (!is_string($routingParam))
        {
            throw new \InvalidArgumentException('$routingParam has to be a string');
        }

        $this->routingParam = $routingParam;
    }


    /**
     * @param Router $systemRouter
     */
    public function setSystemRouter($systemRouter)
    {
        $this->systemRouter = $systemRouter;
    }


    /**
     * @param \Twig_Environment $twig
     */
    public function setTwig(\Twig_Environment $twig)
    {
        $this->twig = $twig;
    }

}
