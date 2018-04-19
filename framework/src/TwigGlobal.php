<?php
namespace Legato\Framework;

use Legato\Framework\Session\SessionManager;

class TwigGlobal extends AbstractTwigGlobal
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