<?php

namespace Legato\Framework;

class Twig extends View
{
    public function __construct($view, $data)
    {
        parent::__construct();
        $loader = new \Twig_Loader_Filesystem($this->basePath);
        $twig = new \Twig_Environment($loader);
    
        /**
         * Load global extensions
         */
        $twig->addExtension(new TwigGlobal);
    
        try{
            echo $twig->render($view, $data);
        }catch (\Exception $exception){
            die($exception->getMessage());
        }
    }
}