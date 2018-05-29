<?php

namespace Legato\Framework;

use Legato\Framework\Session\SessionManager;

class TwigGlobal extends AbstractTwigGlobal
{
    use SessionManager;
    protected $config = [];

    public function getGlobals()
    {
        return array_merge($this->getDefaults(), $this->getUserDefinedGlobals());
    }

    /**
     * get the default globals available for twig template.
     *
     * @return array
     */
    private function getDefaults()
    {
        return [
            'flash'             => $this->getFlashMessage('flash'),
            'success'           => $this->get('success'),
            'validation_errors' => [],
            'error'             => $this->get('error'),
        ];
    }

    /**
     * Get the user defined global for twig templates.
     *
     * @return mixed
     */
    protected function getUserDefinedGlobals()
    {
        if (file_exists(realpath(__DIR__.'/../../../../config/twig.php'))) {
            $this->config = require realpath(__DIR__.'/../../../../config/twig.php');
        } elseif (file_exists(realpath(__DIR__.'/../config/twig.php'))) {
            $this->config = require realpath(__DIR__.'/../config/twig.php');
        }

        return isset($this->config['twig_global']) ? $this->config['twig_global'] : [];
    }
}
