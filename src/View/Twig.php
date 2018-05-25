<?php

namespace Legato\Framework;

class Twig extends View
{

    private $config;

    /**
     * Twig constructor.
     *
     * @param $view
     * @param $data
     * @param $options
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
    
        /**
         * Load global extensions
         */
        $this->registerExtension($twig);

        echo $twig->render($view.'.twig', $data);
    }

    /**
     * Get extensions defined by application developer
     *
     * @return array
     */
    private function getExtensions()
    {
        if(file_exists(realpath(__DIR__ . '/../../../../../config/twig.php'))){
            $this->config = require realpath(__DIR__ . '/../../../../../config/twig.php');
        }else{
            $this->config = require realpath(__DIR__ . '/../../config/twig.php');
        }
        return isset($this->config['extensions'])? $this->config['extensions'] : [] ;
    }

    /**
     * Register twig extensions
     *
     * @param \Twig_Environment $twig
     */
    public function registerExtension(\Twig_Environment $twig)
    {
        $extensions = $this->getExtensions();
        if( count($extensions) ) {
            foreach ( $extensions as $key => $extension ){

                if($key == 'debug' && 'false' === config('APP_DEBUG')) {
                    continue;
                }

                $twig->addExtension(new $extension);
            }
        }
    }
}