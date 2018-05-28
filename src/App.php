<?php


namespace Legato\Framework;

use Illuminate\Container\Container;
use Legato\Framework\Security\CSRFProtection;

class App
{
    /**
     * Application version number
     */
    const VERSION = '1.1.6';

    /**
     * Application name
     */
    const NAME = 'Legato Framework';

    /**
     * IOC container
     *
     * @var $container
     */
    protected $container;

    protected $middleWares = [];

    public function __construct(Container $container)
    {
        $this->container = $container;
        $this->resolveDependencies($this->dependencies());
        $this->middleWares = $this->getMiddleWares();

        //$this->boot();
    }

    /**
     * Application boot method
     */
    public function boot()
    {
        $this->bootMiddleWares();
    }

    /**
     * Resolve application boot middleware
     */
    protected function bootMiddleWares()
    {
        if(isset($this->middleWares['boot']) && count($this->middleWares['boot'])){
            foreach ($this->middleWares['boot'] as $middleware => $handler){
                $this->container->call(array($this->container->make($middleware), $handler));
            }
            return [];
        }

        /**
         * Framework development mood
         */
        $CSRFProtection =  $this->container->make(CSRFProtection::class);
        return $this->container->call(array($CSRFProtection, 'handle'));
    }

    /**
     * Application dependency binding to container
     *
     * @param array $dependencies
     */
    protected function resolveDependencies(array $dependencies)
    {
       foreach ($dependencies as $dependency => $type){
           call_user_func_array([$this, $type], [$dependency]);
       }
    }

    /**
     * Register a binding with the container.
     *
     * @param $target
     */
    protected function bind($target)
    {
        $this->container->bind($target);
    }

    /**
     * Set a given type to shared.
     *
     * @param $target
     */
    protected function shared($target)
    {
        $this->container->isShared($target);
    }

    /**
     * Register a shared binding in the container.
     *
     * @param $target
     */
    protected function singleton($target)
    {
        $this->container->singleton($target);
    }

    /**
     * Get all registered middleware
     *
     * @return array|mixed
     */
    protected function getMiddleWares()
    {
        if(file_exists(realpath(__DIR__ . '/../../../../app/middleware/register.php'))){
           return require_once realpath(__DIR__ . '/../../../../app/middleware/register.php');
        }

        return [];
    }

    /**
     * Get user defined dependencies
     *
     * @return array
     */
    protected function getUserDefinedDependencies()
    {
        $dependencies = getConfigPath('app', 'dependencies');
        return is_null($dependencies) ? [] : $dependencies;
    }

    /**
     * combine all dependencies
     *
     * @return array
     */
    protected function dependencies(){
        $defaults = [
            \Legato\Framework\Request::class => 'shared',
        ];

        return array_merge($defaults, $this->getUserDefinedDependencies());
    }

    /**
     * Resolve the given type from illuminate container.
     *
     * @param  string  $type
     * @param  array  $parameters (optional)
     * @return mixed
     */
    public function construct($type, array $parameters = [])
    {
        return $this->container->make($type, $parameters);
    }

    /**
     * Call and inject its dependencies for the given class / method or closure.
     *
     * @param  callable|string  $callback
     * @param  array  $parameters (optional)
     * @param  string|null  $defaultMethod (optional)
     * @return mixed
     */
    public function execute($callback, array $parameters = [], $defaultMethod = null)
    {
        return $this->container->call($callback, $parameters, $defaultMethod);
    }

}