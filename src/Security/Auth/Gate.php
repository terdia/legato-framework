<?php


namespace Legato\Framework\Security;


use Exception;

class Gate
{
    const NOT_ACTIVATED = 'Account not activated';
    const BAD_CREDENTIALS = 'These credentials do not match our records.';
    const VALID = true;

    /**
     * Attempt to Authenticate the given user
     *
     * @param array $credentials
     * @param bool $remember
     * @return bool|string
     * @throws Exception
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

        /**
         * Remember the user
         */
        if($remember)
        {
            static::rememberMe($authConfig, $user);
        }

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
        $fields = static::getFields($authConfig);

        if(is_array($fields) && count($fields) == 2){
            return $model::where($fields[0], $username)->orWhere($fields[1], $username)->first();
        }

        return $model::where($fields[0], $username)->first();
    }

    /**
     * Set login session
     *
     * @param array $authConfig
     * @param $user
     * @throws \Exception
     */
    public static function loginSession(array $authConfig, $user)
    {
        $key = static::getFields($authConfig, true);
        $encrypted = encrypt($user->$key);
        session()->set('log_me_in', $encrypted);
    }

    /**
     * Remember the user for 14 days
     *
     * @param array $authConfig
     *
     * @param $user
     * @return void
     * @throws \Exception
     */
    public static function rememberMe(array $authConfig, $user)
    {
        $key = static::getFields($authConfig, true);
        $token = encrypt($user->$key);

        setCookie('remember_token', $token, time() + (86400 * 14));
    }

    /**
     * Get the field for authentication
     *
     * @param array $authConfig
     * @param bool $first
     * @return mixed
     */
    public static function getFields(array $authConfig, $first = false)
    {
        return $first !== false ? $authConfig['fields'][0] : $authConfig['fields'];
    }
}