<?php


namespace Legato\Framework\Routing;
use FastRoute;

class Route
{
    public static $routes = [];

    public static function post($target, $handler)
    {
        array_push(static::$routes, ['method' => 'POST', 'target' => $target, 'handler' => $handler]);
    }

    public static function get($target, $handler)
    {
        array_push(static::$routes, ['method' => 'GET', 'target' => $target, 'handler' => $handler]);
    }

    public static function put($target, $handler)
    {
        array_push(static::$routes, ['method' => 'PUT', 'target' => $target, 'handler' => $handler]);
    }

    public static function patch($target, $handler)
    {
        array_push(static::$routes, ['method' => 'PATCH', 'target' => $target, 'handler' => $handler]);
    }

    public static function delete($target, $handler)
    {
        array_push(static::$routes, ['method' => 'DELETE', 'target' => $target, 'handler' => $handler]);
    }

    public static function group($prefix, array $targets)
    {
        foreach ($targets as $target)
        {
            if(count($target) < 3) {
                throw new \ArgumentCountError('Missing data for route group');
            }
            array_push(static::$routes, [
                'method' => $target[0], 'target' => "{$prefix}{$target[1]}", 'handler' => $target[2]
            ]);
        }
    }

    public static function all()
    {
        return FastRoute\simpleDispatcher(function (FastRoute\RouteCollector $router){
            foreach (static::$routes as $route) {
                $router->addRoute($route['method'], $route['target'], $route['handler']);
            }
        });
    }
}