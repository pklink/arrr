<?php

namespace CptHook;

use \Symfony\Component\HttpFoundation;
use \CptHook\Service\Autoloadable;

class Sir
{

    /**
     * @var \Dotor\Dotor
     */
    protected $config;


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
        // set properties
        $this->config   = new \Dotor\Dotor($config);
        $this->services = new \SplPriorityQueue();
        $this->request  = HttpFoundation\Request::createFromGlobals();

        $this->init();



        // Receiver
        /*
        $receiver = $config['receiver'];
        $this->services[] = new \CptHook\Service\Receiver($receiver);
        */
    }


    /**
     * @return void
     */
    protected function createServices()
    {
        // Default Services
        $defaultServices = [
            'viewer' => '\CptHook\Service\Viewer\Factory',
        ];

        // add services
        foreach ($this->config->get('services', $defaultServices) as $configName => $factoryName)
        {
            /* @var \CptHook\Service\Factory $factoryName */
            /* @var Service $service */
            $service = $factoryName::create($this->config->get($configName, []));
            $this->services->insert($service, $service->getPriority());
        }
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
    public function init()
    {
        // transform errors to exceptions
        \Eloquent\Asplode\Asplode::instance()->install();

        // set webroot
        if ($this->config->get('webroot') !== null)
        {
            $file = debug_backtrace()[0]['file'];
            $this->setWebroot(pathinfo($file, PATHINFO_DIRNAME));
        }
        else
        {
            $this->setWebroot($this->config->get('webroot'));
        }

        $this->createServices();
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
    public function arrr()
    {
        while ($this->services->valid())
        {
            /* @var Service $service */
            $service = $this->services->extract();

            // get routing param and param
            $routingParam = $service->getRoutingParam();
            $param        = $this->request->get($routingParam);

            // check if routing param is in request
            if ($param !== null)
            {
                $service->run($param);
            }
            else if ($service instanceof Autoloadable)
            {
                /* @var Service\Autoloadable $service */
                $service->run($service->getDefaultParam());
            }
        }
    }

}
