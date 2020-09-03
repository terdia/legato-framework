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

namespace Legato\Framework\View;

class Twig extends View
{
    private $config;

    /**
     * Twig constructor.
     *
     * @param $view
     * @param $data
     * @param $options
     *
     * @throws \Twig_Error_Loader
     * @throws \Twig_Error_Runtime
     * @throws \Twig_Error_Syntax
     */
    public function __construct($view, $data, array $options = [])
    {
        parent::__construct();
        $loader = new \Twig_Loader_Filesystem($this->basePath);

        $options += [
            'debug' => config('APP_DEBUG'),
        ];

        $twig = new \Twig_Environment($loader, $options);

        /*
         * Load global extensions
         */
        $this->registerExtension($twig);

        echo $twig->render($view.'.twig', $data);
    }

    /**
     * Get extensions defined by application developer.
     *
     * @return array
     */
    protected function getExtensions()
    {
        if (file_exists(realpath(__DIR__.'/../../../../../config/twig.php'))) {
            $this->config = require realpath(__DIR__.'/../../../../../config/twig.php');
        } else {
            $this->config = require realpath(__DIR__.'/../../config/twig.php');
        }

        return isset($this->config['extensions']) ? $this->config['extensions'] : [];
    }

    /**
     * Register twig extensions.
     *
     * @param \Twig_Environment $twig
     */
    private function registerExtension(\Twig_Environment $twig)
    {
        $extensions = $this->getExtensions();
        if (count($extensions)) {
            foreach ($extensions as $key => $extension) {
                $this->load($twig, $key, $extension);
            }
        }
    }

    /**
     * @param \Twig_Environment $twig
     * @param $key
     * @param $extension
     */
    private function load(\Twig_Environment $twig, $key, $extension)
    {
        if ($key == 'debug' && 'false' === config('APP_DEBUG')) {
            //
        } else {
            $twig->addExtension(new $extension());
        }
    }
}
