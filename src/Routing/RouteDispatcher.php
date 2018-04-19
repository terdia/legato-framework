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
        $uri = $request->uri();


        $this->container = $container;
        $this->container->bind(Request::class);
        $this->container->bind(Session::class);

        // Strip query string (?foo=bar) and decode URI
        if (false !== $pos = strpos($uri, '?')) {
            $uri = substr($uri, 0, $pos);
        }
        $uri = rawurldecode($uri);

        $routeInfo = $dispatcher->dispatch($requestMethod, $uri);
        switch ($routeInfo[0]) {
            case FastRoute\Dispatcher::NOT_FOUND:
                die('404 Not Found');
                break;
            case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
                $allowedMethods = $routeInfo[1];
                die($allowedMethods.' Method not allowed for this route');
                break;
            case FastRoute\Dispatcher::FOUND:
                $handler = $routeInfo[1];

                list($controller, $action) = explode('@', $handler);
                $vars = $routeInfo[2];

                /*$this->container->when($controller)->needs(Request::class)->give($request);
                $this->container->when(BaseController::class)->needs(Session::class)->give($session);*/

                $class = $this->container->make($controller);
                $this->container->call(array($class, $action), $vars);
                //call_user_func_array(array(new $controller($request), $action), $vars);
                break;
        }
    }

}