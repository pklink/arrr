<?php

namespace CptHook;

use Symfony\Component\HttpFoundation\Request;

class CMS
{

    /**
     * @var Router
     */
    protected $contentRouter;

    /**
     * @var Router
     */
    protected $systemRouter;

    /**
     * @var Request
     */
    protected $request;

    /**
     * @var \Twig_Environment
     */
    protected $twig;


    /**
     * @var string
     */
    protected $routingParam = 'r';


    /**
     * @param \CptHook\Router $systemRouter
     */
    public function setSystemRouter($systemRouter)
    {
        $this->systemRouter = $systemRouter;
    }


    /**
     * @return \CptHook\Router
     */
    public function getSystemRouter()
    {
        return $this->systemRouter;
    }


    /**
     * @param array $config
     */
    public function __construct(array $config = array())
    {
        Mark::arr($config, $this);
    }

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     */
    public function setRequest($request)
    {
        $this->request = $request;
    }

    /**
     * @return \Symfony\Component\HttpFoundation\Request
     */
    public function getRequest()
    {
        return $this->request;
    }

    /**
     * @param \CptHook\Router $router
     */
    public function setContentRouter(\CptHook\Router $router)
    {
        $this->contentRouter = $router;
    }

    /**
     * @return \CptHook\Router
     */
    public function getContentRouter()
    {
        return $this->contentRouter;
    }


    /**
     * @param $routingParam
     * @throws \InvalidArgumentException
     */
    public function setRoutingParam($routingParam)
    {
        if (!is_string($routingParam))
        {
            throw new \InvalidArgumentException('$routingParam must be a string');
        }

        $this->routingParam = $routingParam;
    }

    /**
     * @return string
     */
    public function getRoutingParam()
    {
        return $this->routingParam;
    }

    /**
     * @param \Twig_Environment $twig
     */
    public function setTwig(\Twig_Environment $twig)
    {
        $this->twig = $twig;
    }


    /**
     * @return \Twig_Environment
     */
    public function getTwig()
    {
        return $this->twig;
    }


    /**
     * @return void
     */
    public function run()
    {
        // get contentRouter
        $route = $this->request->get($this->routingParam, 'home');

        // handle contentRouter
        try {
            $content = $this->contentRouter->handleRoute($route);

        // route does not exist -> 404
        } catch (\FileRouter\Exception\Route\DoesNotExist $e) {
            $content = $this->contentRouter->handleRoute('system/404');
        }

        // render template
        echo $this->twig->render('index.twig', array(
            'title'      => $this->systemRouter->handleRoute('title'),
            'footer'     => $this->systemRouter->handleRoute('footer'),
            'navigation' => $this->systemRouter->handleRoute('navigation'),
            'content'    => $content,
        ));
    }

}
