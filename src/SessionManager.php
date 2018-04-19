<?php

namespace Legato\Framework\Session;
use Symfony\Component\HttpFoundation\Session\Session;


trait SessionManager
{

    public function set($key, $value)
    {
        (new Session)->set($key, $value);
    }

    public function get($key)
    {
        return (new Session)->get($key);
    }

    public function createFlashMessage($key, $value)
    {
        (new Session)->getFlashBag()->add($key, $value);
    }

    public function getFlashMessage($key)
    {
        $session = new Session;
        foreach ($session->getFlashBag()->get($key, array()) as $message) {
            return $message?:null;
        }

        return '';
    }

}