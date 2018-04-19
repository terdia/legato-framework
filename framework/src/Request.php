<?php

namespace Legato\Framework;

use Symfony\Component\HttpFoundation\Request as HttpFoundation;

class Request extends HttpFoundation
{
    public $request;
    public $response;

    public function __construct()
    {
        parent::__construct();
        $this->request = $this->getRequestInstance();
    }

    public function getRequestInstance(){
        return HttpFoundation::createFromGlobals();
    }

    public function input($key, $default = false)
    {
        if(strtolower($this->request->getMethod()) === 'post'){
            if($this->request->request->has($key)){
                return $this->request->request->get($key);
            }
        }

        if(strtolower($this->request->getMethod()) ==='get'){
            if($this->request->query->has($key)) {
                return $this->request->query->get($key);
            }
        }

        if($this->attributes->has($key)){
            return $this->attributes->get($key);
        }

        return $default;
    }

    public function uri()
    {
       return $this->request->getRequestUri();
    }

    public function path()
    {
        return $this->request->getPathInfo();
    }

    public function all()
    {
        return $this->request->request->all()?:$this->attributes->all();
    }

}