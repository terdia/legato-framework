<?php

namespace Legato\Framework;

use Legato\Framework\Session\Session;
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

    public function getRequestInstance()
    {
        return HttpFoundation::createFromGlobals();
    }

    /**
     * Get a request parameter by key.
     *
     * @param $key
     * @param bool $default
     *
     * @return bool|mixed
     */
    public function input($key, $default = false)
    {
        return $this->getRequestInputByType()->has($key) ?
            $this->getRequestInputByType()->get($key) : $default;
    }

    /**
     * Get the request uri.
     *
     * @return string
     */
    public function uri()
    {
        return $this->instance->getRequestUri();
    }

    /**
     * Get the request path.
     *
     * @return string
     */
    public function path()
    {
        return $this->instance->getPathInfo();
    }

    /**
     * get all request data by request type.
     *
     * @return array
     */
    public function all()
    {
        return $this->getRequestInputByType()->all();
    }

    /**
     * get the request data base on request method.
     *
     * @return \Symfony\Component\HttpFoundation\ParameterBag
     */
    public function getRequestInputByType()
    {
        return $this->instance->getRealMethod() == 'GET' ? HttpFoundation::createFromGlobals()->query :
            HttpFoundation::createFromGlobals()->request;
    }

    /**
     * The ip address of the client.
     *
     * @return null|string
     */
    public function clientIp()
    {
        return $this->instance->getClientIp();
    }

    /**
     * User agent of the client.
     *
     * @return string|string[]
     */
    public function clientUserAgent()
    {
        return $this->instance->headers->get('User-Agent');
    }

    /**
     * Get specific header.
     *
     * @param $key
     * @param bool $default
     *
     * @return bool|string|string[]
     */
    public function getHeader($key, $default = false)
    {
        return $this->headers->has($key) ? $this->headers->get($key) : $default;
    }

    /**
     * Set header.
     *
     * @param $key
     * @param $value
     */
    public function setHeader($key, $value)
    {
        return $this->headers->set($key, $value);
    }

    /**
     * Get session through request.
     *
     * @return null|\Symfony\Component\HttpFoundation\Session\SessionInterface
     */
    public function session()
    {
        return Session::getInstance();
    }

    /**
     * Get the real request method.
     *
     * @return string
     */
    public function method()
    {
        return $this->instance->getRealMethod();
    }

    /**
     * Get all the data from PHP $_FILES super global.
     *
     * @return \Symfony\Component\HttpFoundation\ServerBag
     */
    public function file()
    {
        return $this->instance->files;
    }

    /**
     * Get all the data from PHP $_COOKIES super global.
     *
     * @return \Symfony\Component\HttpFoundation\ServerBag
     */
    public function cookies()
    {
        return $this->instance->cookies;
    }

    /**
     * Get all the data from PHP $_SERVER super global.
     *
     * @return \Symfony\Component\HttpFoundation\ServerBag
     */
    public function server()
    {
        return $this->instance->server;
    }
}
