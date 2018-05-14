<?php

namespace Legato\Framework;

use Symfony\Component\HttpFoundation\Request as HttpFoundation;

class Request extends HttpFoundation
{
    public $instance;
    public $response;

    public function __construct()
    {
        parent::__construct();
        $this->instance = $this->getRequestInstance();
    }

    public function getRequestInstance(){
        return HttpFoundation::createFromGlobals();
    }

    /**
     * Get a request parameter by key
     *
     * @param $key
     * @param bool $default
     * @return bool|mixed
     */
    public function input($key, $default = false)
    {
        return $this->getRequestInputByType()->has($key) ? $this->getRequestInputByType()->get($key) : $default;
    }

    /**
     * Get the request uri
     *
     * @return string
     */
    public function uri()
    {
        return $this->instance->getRequestUri();
    }

    /**
     * Get the request path
     *
     * @return string
     */
    public function path()
    {
        return $this->instance->getPathInfo();
    }

    /**
     * get all request data by request type
     *
     * @return array
     */
    public function all()
    {
        return $this->getRequestInputByType()->all();
    }

    /**
     * get the request data base on request method
     *
     * @return \Symfony\Component\HttpFoundation\ParameterBag
     */
    public function getRequestInputByType()
    {
        return $this->instance->getRealMethod() == 'GET' ? HttpFoundation::createFromGlobals()->query :
            HttpFoundation::createFromGlobals()->request;
    }

    /**
     * The ip address of the client
     *
     * @return null|string
     */
    public function clientIp()
    {
        return $this->instance->getClientIp();
    }

    /**
     * User agent of the client
     *
     * @return string|string[]
     */
    public function clientUserAgent()
    {
        return $this->instance->headers->get('User-Agent');
    }

}