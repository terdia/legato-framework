<?php


namespace Legato\Framework;

use Illuminate\Database\Capsule\Manager as Capsule;

class Connection extends Capsule
{
    public function __construct(){
        parent::__construct();
        
        $this->connect();
        $this->setAsGlobal();
        $this->bootEloquent();
    }
    
    public function connect()
    {
        $this->addConnection([
            'driver' => config('DB_DRIVER', 'mysql'),
            'host' => config('HOST', 'localhost'),
            'database' => config('DB_NAME', 'store'),
            'username' => config('DB_USERNAME', 'store'),
            'password' => config('DB_PASSWORD', 'secret'),
            'charset' => 'utf8',
            'collation' => 'utf8_unicode_ci',
            'prefix' => ''
        ]);
    }
}