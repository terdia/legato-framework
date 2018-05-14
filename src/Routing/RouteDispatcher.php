<?php

namespace Legato\Framework\Routing;

use Legato\Framework\Request;
use Illuminate\Container\Container;
use Symfony\Component\HttpFoundation\Session\Session;
use AltoRouter;

class RouteDispatcher
{
    protected $controller;
    protected $methods;
    protected $container;
    protected $dispatcher;

    public function __construct(Request $request, Container $container,
                                Session $session, AltoRouter $router)
    {

        $this->dispatcher = $router->match();

        if($this->dispatcher){
            $this->container = $container;
            $this->container->bind(Request::class);
            $this->container->bind(Session::class);

            $this->handle($this->dispatcher['target'], $this->dispatcher['params']);
        }else{
            header($_SERVER['SERVER_PROTOCOL'].'404 Not Found');
            die('404 Not Found');
        }

    }

    /**
     * Handler for route found, support Closure and Controller methods
     *
     * @param $handler
     * @param $parameters
     */
    private function handle($handler, $parameters)
    {
        if($handler instanceof \Closure){
            $this->container->call($handler, $parameters);

        }else{
            list($controller, $action) = explode('@', $handler);

            $class = $this->container->make($controller);
            $this->container->call(array($class, $action), $parameters);
        }
    }
}