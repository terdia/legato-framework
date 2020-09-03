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

namespace Legato\Framework;

use Symfony\Component\HttpFoundation\Session\Session;

trait SessionManager
{
    public function set($key, $value)
    {
        (new Session())->set($key, $value);
    }

    public function get($key)
    {
        return (new Session())->get($key);
    }

    public function createFlashMessage($key, $value)
    {
        (new Session())->getFlashBag()->add($key, $value);
    }

    public function getFlashMessage($key)
    {
        $session = new Session();
        foreach ($session->getFlashBag()->get($key, []) as $message) {
            return $message ?: null;
        }

        return '';
    }
}
