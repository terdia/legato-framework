<?php

namespace Legato\Framework;

use Philo\Blade\Blade as LaravelBlade;

class Blade extends View
{
    public function __construct($view, $data)
    {
        parent::__construct();
        $blade = new LaravelBlade($this->basePath, $this->cache);
        echo $blade->view()->make($view, $data)->render();
    }
}
