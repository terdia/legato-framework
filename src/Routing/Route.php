<?php


namespace Legato\Framework\Routing;
use AltoRouter;

class Route
{
    public static $routes = [];

    public static function post($target, $handler, $name = null)
    {
        array_push(static::$routes, ['method' => 'POST', 'target' => $target,
            'handler' => $handler, 'name' => $name]);
    }

    public static function get($target, $handler, $name = null)
    {
        array_push(static::$routes, ['method' => 'GET', 'target' => $target,
            'handler' => $handler, 'name' => $name]);
    }

    public static function put($target, $handler, $name = null)
    {
        array_push(static::$routes, ['method' => 'PUT', 'target' => $target, 'handler' => $handler]);
    }

    public static function patch($target, $handler, $name = null)
    {
        array_push(static::$routes, ['method' => 'PATCH', 'target' => $target, 'handler' => $handler]);
    }

    public static function delete($target, $handler, $name = null)
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

            isset($target[3]) ? $name = $target[3]: $name = null;
            array_push(static::$routes, [
                'method' => $target[0], 'target' => "{$prefix}{$target[1]}",
                'handler' => $target[2], 'name' => $name
            ]);
        }
    }

    public static function all()
    {
        $router = new AltoRouter;

        foreach (static::$routes as $route) {
            isset($route['name']) ? $name = $route['name']: $name = null;
            $router->map($route['method'], $route['target'], $route['handler'], $name);
        }

        return $router;
    }
}