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

        /**
         * if the user is accessing the app via localhost/project/public
         * we set the parse the request uri so that it matches a defined route
         */
        $this->setRequestUri($request->uri());

        $this->dispatcher = $router->match();

        if($this->dispatcher){
            $this->container = $container;
            $this->container->isShared(Request::class);
            $this->container->bind(Session::class);

            $this->handle($this->dispatcher['target'], $this->dispatcher['params']);
        }else{
            header($_SERVER['SERVER_PROTOCOL'].'404 Not Found');
            view('errors/404');
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

    /**
     * We attempt to parse direct request to localhost/public/
     * or localhost/public/index.php
     *
     * @param $uri
     * @return bool|string
     */
    private function prepareUriForLocalhostAccess($uri)
    {
        $public = 'public';
        $index = 'index.php';

        if(strpos($uri, $index))
        {
            return substr($uri, strpos($uri, $index) + strlen($index));
        }else if(strpos($uri, $public))
        {
            return substr($uri, strpos($uri, $public) + strlen($public));
        }

        return false;
    }
    /**
     * Get the request uri
     *
     * @param $uri
     */
    private function setRequestUri($uri)
    {
        if($this->prepareUriForLocalhostAccess($uri)){
            $_SERVER['REQUEST_URI'] = $this->prepareUriForLocalhostAccess($uri);
        }
    }
}