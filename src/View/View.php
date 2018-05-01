<?php

namespace Legato\Framework;

abstract class View
{
    public $basePath;
    
    public $cache;
    
    public function __construct()
    {
        $this->basePath = $this->viewPath();
        $this->cache = $this->cachePath();
    }
    
    
    public function viewPath()
    {
        if(file_exists(realpath(__DIR__.'/../../../../../resources/views'))){
            return realpath(__DIR__.'/../../../../../resources/views');
        }
        
        return realpath(__DIR__ . '/../../resources/views');
    }
    
    public function cachePath()
    {
        if(file_exists(realpath(__DIR__.'/../../../../../resources/views'))){
            return realpath(__DIR__.'/../../../../../cache/blade');
        }
        
        return realpath(__DIR__ . '/../../cache/blade');
    }
}