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

namespace Legato\Framework\Database;

use Illuminate\Database\Capsule\Manager as Capsule;

class Connection extends Capsule
{
    public function __construct()
    {
        parent::__construct();

        $this->connect();
        $this->setAsGlobal();
        $this->bootEloquent();
    }

    public function connect()
    {
        $this->addConnection([
            'driver'    => config('DB_DRIVER', 'mysql'),
            'host'      => config('HOST', 'localhost'),
            'database'  => config('DB_NAME', ''),
            'username'  => config('DB_USERNAME', ''),
            'password'  => config('DB_PASSWORD', ''),
            'charset'   => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix'    => '',
        ]);
    }
}
