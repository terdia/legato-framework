<?php

namespace Legato\Framework\Routing;

use FastRoute;

use Legato\Framework\Request;
use Illuminate\Container\Container;
use Symfony\Component\HttpFoundation\Session\Session;

class RouteDispatcher
{
    protected $controller;
    protected $methods;
    protected $container;
    protected $dispatcher;

    public function __construct(Request $request, Container $container,
                                Session $session, $dispatcher)
    {
        $requestMethod = $request->getMethod();
        $uri = $this->getUri($request->uri());
        
        $this->container = $container;
        $this->container->bind(Request::class);
        $this->container->bind(Session::class);

        // Strip query string (?foo=bar) and decode URI
        if (false !== $pos = strpos($uri, '?')) {
            $uri = substr($uri, 0, $pos);
        }
        $uri = rawurldecode($uri);

        $routeInfo = $dispatcher->dispatch($requestMethod, $uri);
        $this->match($routeInfo);
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
     * Match route and execute found request
     *
     * @param $routeInfo
     */
    public function match($routeInfo)
    {
        switch ($routeInfo[0]) {
            case FastRoute\Dispatcher::NOT_FOUND:
                die('404 Not Found');
                break;

            case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
                die($routeInfo[1].' Method not allowed for this route');
                break;

            case FastRoute\Dispatcher::FOUND:
                $this->handle($routeInfo[1], $routeInfo[2]);
                break;
        }
    }

    /**
     * We attempt to parse direct request to localhost/public/
     * or localhost/public//index.php
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
        }

        return substr($uri, strpos($uri, $public) + strlen($public));
    }

    /**
     * Get the request uri
     *
     * @param $uri
     * @return bool|string
     */
    private function getUri($uri)
    {
        if($this->prepareUriForLocalhostAccess($uri)){
            return $uri = $this->prepareUriForLocalhostAccess($uri);
        }
        return $uri;
    }
}