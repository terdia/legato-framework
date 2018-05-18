<?php


namespace Legato\Framework\Session;

use Symfony\Component\HttpFoundation\Session\Session as SymfonySession;

class Session extends SymfonySession
{
    protected static $instance;

    /**
     * Session singleton
     *
     * @return mixed
     */
    public static function getInstance()
    {
        if(! static::$instance instanceof Session )
        {
            static::$instance = $session = new Session;
            if(!$session->isStarted()){
                $session->start();
            };
        }
        return static::$instance;
    }

    /**
     * Add flash message
     *
     * @param $key
     * @param $value
     */
    public function createFlashMessage($key, $value)
    {
        $session = static::getInstance();
        $session->getFlashBag()->add($key, $value);
    }

    /**
     * Get message from flash bag
     *
     * @param $key
     * @return null|string
     */
    public function getFlashMessage($key)
    {
        $session = static::getInstance();
        foreach ($session->getFlashBag()->get($key, array()) as $message) {
            return $message?:null;
        }

        return '';
    }
}