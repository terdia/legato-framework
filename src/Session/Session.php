<?php

/*
 * This file is part of the Legato package.
 *
 * (c) Osayawe Ogbemudia Terry <terry@devscreencast.com>
 *
 * For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 *
 */

namespace Legato\Framework\Session;

use Symfony\Component\HttpFoundation\Session\Session as SymfonySession;

class Session extends SymfonySession
{
    protected static $instance;

    /**
     * Session singleton.
     *
     * @return mixed
     */
    public static function getInstance()
    {
        if (!static::$instance instanceof self) {
            static::$instance = $session = new self();
            if (!$session->isStarted()) {
                $session->start();
            }
        }

        return static::$instance;
    }

    /**
     * Add flash message.
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
     * Get message from flash bag.
     *
     * @param $key
     *
     * @return null|string
     */
    public function getFlashMessage($key)
    {
        $session = static::getInstance();
        foreach ($session->getFlashBag()->get($key, []) as $message) {
            return $message ?: null;
        }

        return '';
    }
}
