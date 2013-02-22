<?php

namespace CptHook;

use Symfony\Component\HttpFoundation\Request;

class CMS
{

    /**
     * @var Router
     */
    protected $router;

    /**
     * @var Request
     */
    protected $request;

    /**
     * @var Twig_Environment
     */
    protected $twig;


    /**
     * @var string
     */
    protected $routingParam = 'r';


    /**
     * @param array $config
     */
    public function __construct(array $config = array())
    {
        $this->init($config);
    }


    public function run()
    {
        // get router
        $route = $this->request->get($this->routingParam, '');

        // handle router
        try {
            $content = $this->router->handleRoute($route);
        } catch (\FileRouter\Exception\Route\DoesNotExist $e) {
            $content = $this->router->handleRoute('system/404');
        }

        // twig
        echo $this->twig->render('index.twig', array(
            'title'      => $this->router->handleRoute('system/title'),
            'footer'     => $this->router->handleRoute('system/footer'),
            'navigation' => $this->router->handleRoute('system/navigation'),
            'content'    => $content,
        ));
    }


    /**
     * @param array $config
     *      string routingParam = r
     *      string documentPath = content
     *      string templatePath = themes/default
     */
    private function init(array $config = array())
    {
        // routing param
        if (isset($config['routingParam']))
        {
            $this->routingParam = $config['routingParam'];
        }

        // markdown path & router
        if (!isset($config['documentPath']))
        {
            $config['documentPath'] = realpath(__DIR__ . '/../../content');
        }

        $sourcePath   = new \SplFileInfo($config['documentPath']);
        $this->router = new Router($sourcePath);

        // template path & twig
        if (!isset($config['templatePath']))
        {
            $config['templatePath'] = realpath(__DIR__ . '/../../themes/default');
        }

        $loader     = new \Twig_Loader_Filesystem($config['templatePath']);
        $this->twig = new \Twig_Environment($loader);

        // request instance
        $this->request = Request::createFromGlobals();
    }

}
