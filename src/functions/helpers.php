<?php
use Symfony\Component\HttpFoundation\Session\Session;

if (! function_exists('view')) {
    function view($view, $data = []):void
    {
        getenv('FRAMEWORK') == 'developer'?$path_to_views = realpath(__DIR__ . '/../../resources/views'):
            $path_to_views = realpath(__DIR__.'/../../../../../resources/views');
        
        switch (getenv('TEMPLATE_ENGINE'))
        {
            case 'blade':
                
                new \Legato\Framework\Blade($view, $data);
                break;
                
            default:
                new \Legato\Framework\Twig($view, $data);
        }
    }
}

if (! function_exists('redirectTo')) {
    function redirectTo($path)
    {
        //ob_start();
        header("Location: $path");
    }
}

if (! function_exists('flash')) {
    function flash(Session $session, $name):string
    {
        foreach ($session->getFlashBag()->get($name, array()) as $message) {
            return $message?:null;
        }

        return '';
    }
}
