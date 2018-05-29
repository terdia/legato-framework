<?php

namespace Legato\Framework;

use Legato\Framework\Session\SessionManager;

abstract class AbstractTwigGlobal extends \Twig_Extension implements \Twig_Extension_GlobalsInterface
{
    use SessionManager;

    abstract public function getGlobals();
}
