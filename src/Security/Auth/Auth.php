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

namespace Legato\Framework\Security\Auth;

use Exception;
use Legato\Framework\Request;

class Auth
{
    /**
     * logout redirect path.
     *
     * @var string
     */
    protected $logoutRedirectTo = '/login';

    /**
     * Login redirect path.
     *
     * @var string
     */
    protected $loginRedirectTo = '/';

    /**
     * Get the authenticated user.
     *
     * @return mixed
     */
    public static function user()
    {
        $log_me_in = session()->get('log_me_in');

        try {
            $decrypted = decrypt($log_me_in);
        } catch (Exception $exception) {
            return false;
        }

        $authConfig = getConfigPath('app', 'auth');

        return Gate::user($authConfig, $decrypted);
    }

    /**
     * Check if the current user is authenticated.
     *
     * @return bool
     */
    public static function check()
    {
        return static::user() ? true : false;
    }

    /**
     * Check remember user.
     *
     * @param Request $request
     *
     * @return bool|mixed
     */
    public static function remembered(Request $request)
    {
        $remember = readCookie($request, 'remember_token');
        if ($remember != null) {
            try {
                $decrypted = decrypt($remember);
                $authConfig = getConfigPath('app', 'auth');

                return Gate::user($authConfig, $decrypted);
            } catch (Exception $ex) {
                return false;
            }
        }

        return false;
    }

    /**
     * Logout the user.
     */
    public static function logout()
    {
        session()->invalidate();
        setcookie('remember_token', null, time() - 3600);
        redirectTo((new static())->getLogOutRedirectPath());
    }

    /**
     * Get the logout redirect path.
     *
     * @return string
     */
    protected function getLogOutRedirectPath()
    {
        return static::getInstance()->loginRedirectTo;
    }

    /**
     * Get the login redirect path.
     *
     * @return string
     */
    protected function getLoginRedirectPath()
    {
        return static::getInstance()->loginRedirectTo;
    }

    /**
     * Set the path for logout redirect.
     *
     * @param $path
     */
    public function setLogOutRedirectPath($path)
    {
        static::getInstance()->logoutRedirectTo = $path;
    }

    /**
     * Set the path for login redirect.
     *
     * @param $path
     */
    public function setLoginRedirectPath($path)
    {
        static::getInstance()->loginRedirectTo = $path;
    }

    public static function __callStatic($method, $argument)
    {
        return (new static())->$method(...$argument);
    }

    public function getInstance()
    {
        return isset($this) ? $this : new static();
    }
}
