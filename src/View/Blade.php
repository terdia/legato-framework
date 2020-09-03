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

namespace Legato\Framework\View;

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
