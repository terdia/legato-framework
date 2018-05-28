<?php


namespace Legato\Framework\Security;


use App\Models\User;
use ArgumentCountError;

class Gate
{

    const NOT_ACTIVATED = 'Account not activated';
    const BAD_CREDENTIALS = 'These credentials do not match our records.';
    const VALID = true;

    /**
     * @param array $credentials, ['username' => 'value', 'password' => 'value']
     * @param bool $remember
     * @param array $verification, ['column_name' => 'activation_value'] e.g. [ 'activated' => 1 ]
     * @return bool|string
     */
    public static function authenticate(array $credentials, $remember = false, $verification = [])
    {
        $username = $credentials['username'];
        $password = $credentials['password'];

        $user = static::user($username);

        /**
         * if authentication requires email verification, we check the database using data provided
         * by the developer data = ['column_name' => 'activation_value'] e.g. [ 'activated' => 1 ]
         */
        if ( $user && count($verification) && !static::activationRequired($verification, $user)) {
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
        static::login($user);

        return static::VALID;
    }

    /**
     * Check if user account is activated
     *
     * @param array $data
     * @param User $user
     * @return bool
     */
    public static function activationRequired( array $data, User $user )
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
     * @param $username
     * @return mixed
     */
    public static function user($username)
    {
        return User::where('username', $username)->orWhere('email', $username)->first();
    }

    public static function remember(User $user)
    {

    }

    /**
     * Log the user in
     *
     * @param User $user
     */
    public static function login(User $user)
    {
        session()->set('username', $user->username);
    }
}