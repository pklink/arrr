<?php

namespace CptHook;

use \Symfony\Component\HttpFoundation;
use \CptHook\Service\Autoloadable;

class Sir
{

    /**
     * @var \SplPriorityQueue
     */
    protected $services;


    /**
     * @var HttpFoundation\Request
     */
    protected $request;


    /**
     * @var string
     */
    protected $webroot;


    public function __construct(array $config = [])
    {
        $this->init();

        //check if webroot is set
        if (!isset($config['webroot']))
        {
            $file = debug_backtrace()[0]['file'];
            $config['webroot'] = pathinfo($file, PATHINFO_DIRNAME);
        }

        // set webroot
        $this->setWebroot($config['webroot']);

        // Viewer
        $viewer = $config['viewer'];
        $service = Service\Viewer\Factory::create($viewer);
        $this->services->insert($service, $service->getPriority());

        // Receiver
        /*
        $receiver = $config['receiver'];
        $this->services[] = new \CptHook\Service\Receiver($receiver);
        */
    }


    /**
     * @return void
     */
    public function enableDebugging()
    {
        // set exception handler
        set_exception_handler(array(
            new \Exceptionist\GenericExceptionHandler(),
            'handle'
        ));
    }


    /**
     * @return string
     */
    public function getWebRoot()
    {
        return $this->webroot;
    }


    /**
     * @return void
     */
    protected function init()
    {
        // set properties
        $this->services = new \SplPriorityQueue();
        $this->request  = HttpFoundation\Request::createFromGlobals();

        // transform errors to exceptions
        \Eloquent\Asplode\Asplode::instance()->install();
    }


    /**
     * @param $webroot
     */
    public function setWebroot($webroot)
    {
        $this->webroot = $webroot;
    }


    /**
     * @return void
     */
    public function yarrr()
    {
        while ($this->services->valid())
        {
            /* @var \CptHook\Service $service */
            $service = $this->services->extract();

            // get routing param and param
            $routingParam = $service->getRoutingParam();
            $param        = $this->request->get($routingParam);

            // check if routing param is in request
            if ($service instanceof Autoloadable || $param !== null)
            {
                $service->run($param);
            }
        }
    }

}
