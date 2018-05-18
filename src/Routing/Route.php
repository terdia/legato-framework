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
        array_push(static::$routes, ['method' => 'GET|HEAD', 'target' => $target,
            'handler' => $handler, 'name' => $name]);
    }

    public static function put($target, $handler, $name = null)
    {
        array_push(static::$routes, ['method' => 'PUT', 'target' => $target,
            'handler' => $handler, 'name' => $name]);
    }

    public static function patch($target, $handler, $name = null)
    {
        array_push(static::$routes, ['method' => 'PATCH', 'target' => $target,
            'handler' => $handler, 'name' => $name]);
    }

    public static function delete($target, $handler, $name = null)
    {
        array_push(static::$routes, ['method' => 'DELETE', 'target' => $target,
            'handler' => $handler, 'name' => $name]);
    }

    /**
     * Route Group
     *
     * @param $prefix
     * @param array $targets
     */
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

    /**
     * Create a Rest Resource
     *
     * @param $target
     * @param $handler
     */
    public static function resource($target, $handler)
    {
        $route = $target;
        $sanitized = str_replace('/', '', $target);

        static::get($route, $handler."@index", $sanitized."_index");
        static::get($target."/create", $handler."@showCreateForm", $sanitized."_create_form");
        static::post($target, $handler."@save", $sanitized."_save");
        static::get($target."/[i:id]", $handler."@show", $sanitized."_display");
        static::get($target."/[i:id]/edit", $handler."@showEditForm", $sanitized."_edit_form");
        static::post($target."/[i:id]", $handler."@update", $sanitized."_update");
        static::get($target."/[i:id]/delete", $handler."@delete", $sanitized."_delete");
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

    /**
     * Get details of all route, will be used by console command
     *
     * @return array
     */
    public static function list()
    {
        return static::$routes;
    }
}