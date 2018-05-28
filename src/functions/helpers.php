<?php
use Legato\Framework\Session\Session;

if (! function_exists('view')) {
    /**
     * Render view
     * @param $view
     * @param array $data
     * @param array $options
     * @throws Twig_Error_Loader
     * @throws Twig_Error_Runtime
     * @throws Twig_Error_Syntax
     */
    function view($view, $data = [], $options = []):void
    {
        getenv('FRAMEWORK') == 'developer'?$path_to_views = realpath(__DIR__ . '/../../resources/views'):
            $path_to_views = realpath(__DIR__.'/../../../../../resources/views');
        
        switch (getenv('TEMPLATE_ENGINE'))
        {
            case 'blade':
                
                new \Legato\Framework\Blade($view, $data);
                break;
                
            default:
                new \Legato\Framework\Twig($view, $data, $options);
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

/**
 * @deprecated
 */
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
    /**
     * Get value from environment variable or default
     *
     * @param $key
     * @param null $default
     * @return array|false|null|string
     */
    function config($key, $default = null)
    {
        return getenv($key) ? getenv($key) : $default;
    }
}

if (! function_exists('filesystem')){
    /**
     * Get instance of symfony filesystem
     *
     * @return \Symfony\Component\Filesystem\Filesystem
     */
    function filesystem()
    {
        return (new \Legato\Framework\File())->getFileSystem();
    }
}

if (! function_exists('makeMail') )
{
    /**
     * Send email from a file
     *
     * @param $path
     * @param $data
     * @return string
     */
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

if(! function_exists('session')) {
    /**
     * session instance
     */
    function session()
    {
        $session = Session::getInstance();
        if(!$session->isStarted()){
            $session->start();
        };
        return $session;
    }
}

if (! function_exists('csrf_token_field')) {
    /**
     * Generate a CSRF token hidden input field.
     */
    function csrf_token_field()
    {
        echo html_entity_decode('<input type="hidden" name="token" value="'.token().'">');
    }
}

if (! function_exists('token') ) {
    /**
     * Generate a CSRF token
     */
    function token()
    {
        $session = session();

        if($session->has('token')){
            return $session->get('token');
        }

        $token = base64_encode( openssl_random_pseudo_bytes(32));
        $session->set('token', $token);

        return $token;
    }
}

if (! function_exists('isRunningFromConsole') ) {
    /**
     * Determine if application is running from commandline
     *
     * @return bool
     */
    function isRunningFromConsole() {
        return php_sapi_name() == 'cli' || php_sapi_name() == 'phpdbg';
    }
}

if(! function_exists('secret') ) {
    /**
     * Hash a given string
     *
     * @param $plainText
     * @return bool|string
     */
    function secret($plainText)
    {
        return password_hash(
            base64_encode(hash('sha384', $plainText, true)), PASSWORD_DEFAULT
        );
    }
}

if(! function_exists('verify_secret') ) {
    /**
     * Verify that a given string matches stored hash
     *
     * @param $plainText
     * @param $hash
     * @return bool
     */
    function verify_secret($plainText, $hash)
    {
        return password_verify(
            base64_encode(hash('sha384', $plainText, true)), $hash
        );
    }
}

if (! function_exists('user'))
{
    /**
     * Get the authenticated user
     *
     * @return mixed
     */
    function user()
    {
        return \Legato\Framework\Security\Auth::user();
    }
}

if (! function_exists('getConfigPath') ){

    /**
     * get the desired config path
     *
     * @param $path
     * @return mixed
     */
    function getConfigPath($path, $key = null)
    {
        $path = require realpath(__DIR__ . '/../../../../../config/'.$path.'.php');

        if($key == null) {
            return $path;
        }

        return isset($path[$key]) ? $path[$key] : null;
    }
}