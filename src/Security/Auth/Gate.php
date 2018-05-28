<?php


namespace Legato\Framework\Security;


use InvalidArgumentException;


class Gate
{

    const NOT_ACTIVATED = 'Account not activated';
    const BAD_CREDENTIALS = 'These credentials do not match our records.';
    const VALID = true;

    /**
     * @param array $credentials, ['username' => 'value', 'password' => 'value']
     * @param bool $remember
     * @return bool|string
     */
    public static function authenticate(array $credentials, $remember = false)
    {
        $username = $credentials['username'];
        $password = $credentials['password'];

        $authConfig = getConfigPath('app', 'auth');

        $user = static::user($authConfig, $username);

        /**
         * if authentication requires email account activation, we check the database using data provided
         * by the developer data = ['column_name' => 'activation_value'] e.g. [ 'activated' => 1 ]
         */
        if ( $user && count($authConfig['activation']) &&
            !static::activationRequired($authConfig['activation'], $user)) {

            return static::NOT_ACTIVATED;

        }

        /**
         * check for password
         */
        if(!verify_secret($password, $user->password)){
            return static::BAD_CREDENTIALS;
        }

        /**
         * Log in user
         */
        static::loginSession($authConfig, $user);

        return static::VALID;
    }

    /**
     * Check if user account is activated
     *
     * @param array $data
     * @param $user
     * @return bool
     */
    public static function activationRequired( array $data, $user )
    {
        $input = array_keys($data);

        $field = $input[0];
        $value = $data[$field];

        if($user->$field != $value){
            return false;
        }

        return true;
    }

    /**
     * Get the user trying to authenticate
     *
     * @param array $authConfig
     * @param $username
     * @return mixed
     */
    public static function user(array $authConfig, $username)
    {
        $model = $authConfig['model'];
        $fields = $authConfig['fields'];

        if(is_array($fields) && count($fields) == 2){
            return $model::where($fields[0], $username)->orWhere($fields[1], $username)->first();
        }

        return $model::where($fields[0], $username)->first();
    }

    public static function remember($user)
    {

    }

    /**
     * Set login session
     *
     * @param array $authConfig
     * @param $user
     */
    public static function loginSession(array $authConfig, $user)
    {
        $fields = $authConfig['fields'];
        $key = $fields[0];
        session()->set('log_me_in', $user->$key);
    }
}