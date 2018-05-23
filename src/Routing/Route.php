<?php


namespace Legato\Framework\Routing;
use AltoRouter;
use Closure;

class Route
{
    public static $routes = [];
    static $prefixRoutes = [];

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
     * Support method to add group of routes
     *
     * @param $method, HTTP Request method
     * @param $target, the route
     * @param $handler, Closure | Controller@method
     * @param $name, route name optional
     */
    public static function add($method, $target, $handler, $name = null)
    {
        array_push(static::$prefixRoutes, [
            'method' => $method, 'target' => $target,
            'handler' => $handler, 'name' => $name
        ]);
    }

    /**
     * Route Group
     *
     * @param $prefix
     * @param \Closure $callback
     */
    public static function group($prefix, Closure $callback)
    {
        $callback->call(new static);
        foreach (static::$prefixRoutes as $key => $prefixRoute){
            $target = $prefix.$prefixRoute['target'];
            $handler = $prefixRoute['handler'];
            $name = $prefixRoute['name'];

            unset(static::$prefixRoutes[$key]);

            call_user_func_array(
                [new static, strtolower($prefixRoute['method'])],
                [$target, $handler, $name]
            );
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