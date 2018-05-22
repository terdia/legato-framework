<?php


namespace Legato\Framework;

use Illuminate\Container\Container;
use Legato\Framework\Security\CSRFProtection;

class App
{
    /**
     * Application version number
     */
    const VERSION = 1.1;

    /**
     * Application name
     */
    const NAME = 'Legato';

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
           if(is_null($type) || $type == 'bind'){
               $this->container->bind($dependency);
           }else if($type == 'shared'){
               $this->container->isShared($dependency);
           }elseif($type == 'singleton'){
               $this->container->singleton($dependency);
           }
       }
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
        if(file_exists(realpath(__DIR__.'/../../../../config/app.php'))){
            $config = require_once realpath(__DIR__.'/../../../../config/app.php');
            return $config['dependencies'];
        }
        return [];
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