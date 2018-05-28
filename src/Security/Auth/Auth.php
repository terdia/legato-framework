<?php

namespace Legato\Framework\Security;


class Auth
{

    /**
     * Get the authenticated user
     *
     * @return mixed
     */
    public static function user()
    {
        $log_me_in = session()->get('log_me_in');
        $authConfig = getConfigPath('app', 'auth');

       return Gate::user($authConfig, $log_me_in);
    }

    /**
     * Check if the current user is authenticated
     *
     * @return bool
     */
    public static function check()
    {
        return static::user() ? true : false;
    }

}