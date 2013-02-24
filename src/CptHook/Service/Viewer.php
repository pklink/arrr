<?php

namespace CptHook\Service;

use Symfony\Component\HttpFoundation;
use CptHook\Builder;


/**
 * @author Pierre Klink
 * @license MIT See LICENSE file for more details
 */
class Viewer extends AbstractImpl implements Autoloadable
{

    /**
     * @var Viewer\Router
     */
    protected $contentRouter;


    /**
     * @var Viewer\Router
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
     * @return HttpFoundation\Request
     */
    public function getRequest()
    {
        return $this->request;
    }


    /**
     * @return Viewer\Router
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
     * @return Viewer\Router
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
     * @param Viewer\Router $router
     */
    public function setContentRouter(Viewer\Router $router)
    {
        $this->contentRouter = $router;
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
     * @param Viewer\Router $systemRouter
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