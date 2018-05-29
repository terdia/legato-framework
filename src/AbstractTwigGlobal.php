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

use Legato\Framework\Session\SessionManager;

abstract class AbstractTwigGlobal extends \Twig_Extension implements \Twig_Extension_GlobalsInterface
{
    use SessionManager;

    abstract public function getGlobals();
}
