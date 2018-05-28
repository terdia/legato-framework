<?php


namespace Legato\Framework\Cookie;

use Symfony\Component\HttpFoundation\Cookie as SymfonyCookie;

class Cookie extends SymfonyCookie
{
    protected static $instance;

    /**
     * Cookie Instance
     * @param $name
     * @param $value
     * @param int $expire
     * @return mixed
     */
    public static function getInstance($name, $value, $expire, $path, $domain, $secure, $httpOnly, $raw, $sameSite)
    {
        if( $expire == 0 ) $expire = time() +2592000;
        if(! static::$instance instanceof Cookie )
        {
            static::$instance = new Cookie($name, $value, $expire, $path, $domain, $secure, $httpOnly, $raw, $sameSite);
        }
        return static::$instance;
    }
}