<?php

namespace Arrr;

use \Symfony\Component\HttpFoundation;
use \Arrr\Service\Autoloadable;

class Arrr
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


    /**
     * @throws \UnexpectedValueException
     * @throws \InvalidArgumentException
     */
    protected function createServices()
    {
        // add services
        foreach ($this->config->get('services', []) as $serviceName)
        {
            // continue if service not enabled
            if ($this->config->get( sprintf('%s.enabled', $serviceName), true) === false)
            {
                continue;
            }

            // get service config
            $serviceConfig = new \Dotor\Dotor($this->config->get($serviceName));

            // check if config for factory is set
            if ($serviceConfig->get('factory') == null)
            {
                throw new \InvalidArgumentException(sprintf('Factory for service "%s" is not set', $serviceName));
            }

            // save 'factory'-option
            $factoryConfig = $serviceConfig->get('factory');

            // check if $factoryConfig is an array
            if (!is_array($factoryConfig))
            {
                throw new \UnexpectedValueException(sprintf('Factory option for service "%s" has to be an array', $serviceName));
            }

            // check format of $factoryConfig
            if (!isset($factoryConfig[0], $factoryConfig[1]))
            {
                throw new \InvalidArgumentException(sprintf('The format of "factory"-option for service "%s" is invalid. Expected: ["name of factory", "name of create-method"]', $serviceName));
            }

            /* @var \Arrr\Service\Factory $factory */
            /* @var string $createMethod */
            list($factory, $createMethod) = $factoryConfig;

            // check if $factory & $createMethod are strings
            if (!is_string($factory) || !is_string($createMethod))
            {
                throw new \UnexpectedValueException('Arguments of the "factory"-option for the service have to be strings');
            }

            // create reflection of factory
            try {
                $reflection = new \ReflectionClass($factory);
            } catch (\ReflectionException $e) {
                throw new \InvalidArgumentException(sprintf('Factory class for service "%s" does not exist', $serviceName));
            }

            // check if create method does exist
            if (!$reflection->hasMethod($createMethod))
            {
                throw new \InvalidArgumentException(sprintf('%s:%s() does not exist', $factory, $createMethod));
            }

            // check if create method is static
            if (!$reflection->getMethod($createMethod)->isStatic())
            {
                throw new \InvalidArgumentException(sprintf('%s:%s() is not static', $factory, $createMethod));
            }

            // create service
            /* @var Service $service */
            $service = $factory::$createMethod($serviceConfig->get());
            $this->services->insert($service, $service->getPriority());
        }
    }


    /**
     * @return void
     */
    protected function enableDebugging()
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

        if ($this->config->get('debug', false))
        {
            $this->enableDebugging();
        }

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

}
