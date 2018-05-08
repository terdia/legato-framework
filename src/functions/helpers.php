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

if (! function_exists('config')) {
    function config($key, $default = null)
    {
        return getenv($key) ? getenv($key) : $default;
    }
}

if (! function_exists('filesystem')){
    function filesystem()
    {
        return (new \Legato\Framework\File())->getFileSystem();
    }
}

/**
 * Send email from a file
 */
if (! function_exists('makeMail') )
{
    function makeMail($path, $data)
    {
        extract($data);
        ob_start();

        if(filesystem()->exists(realpath(__DIR__.'/../../../../../resources/views')))
        {
            include( __DIR__.'/../../../../../resources/views/'. $path );
        }else{
            include(__DIR__.'/../../resources/views/'.$path);
        }

        $content = ob_get_contents();
        ob_end_clean();
        return $content;
    }
}
