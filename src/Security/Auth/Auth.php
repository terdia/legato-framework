<?php


namespace Legato\Framework\Security;


use App\Models\User;

class Auth
{

    /**
     * Get the authenticated user
     *
     * @return mixed
     */
    public static function user()
    {
        $username = session()->get('username');
        return User::where('username', $username)->orWhere('email', $username)->first();
    }

}