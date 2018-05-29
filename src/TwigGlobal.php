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
