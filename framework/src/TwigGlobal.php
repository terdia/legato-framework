<?php
namespace Legato\Framework;

use Legato\Framework\Session\SessionManager;

class TwigGlobal extends \Twig_Extension implements \Twig_Extension_GlobalsInterface
{
    use SessionManager;

    public function getGlobals()
    {
        return [
          'flash' => $this->getFlashMessage('flash'),
          'success' => $this->get('success'),
          'validation_errors' => [],
          'error' => $this->get('error'),
        ];
    }
}