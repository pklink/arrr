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


    public function __construct(array $config = [])
    {
        $this->services = new \SplPriorityQueue();
        $this->request  = HttpFoundation\Request::createFromGlobals();

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
    public function yarrr()
    {
        while ($this->services->valid())
        {
            /* @var \CptHook\Service $service */
            $service = $this->services->extract();

            // get routing param
            $routingParam = $service->getRoutingParam();

            // check if routing param is in request
            if ($service instanceof Autoloadable || $this->request->get($routingParam) !== null)
            {
                $service->run();
            }
        }
    }


}
