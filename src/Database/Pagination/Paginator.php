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

namespace Legato\Framework\Database\Pagination;

use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\HtmlString;
use Philo\Blade\Blade as LaravelBlade;

class Paginator extends LengthAwarePaginator
{
    protected $viewPath = __DIR__.'/views';
    protected $cache = __DIR__.'/cache';
    protected $view = 'bootstrap-4';

    public function links($view = null, $data = [])
    {
        if (is_null($view)) {
            $view = $this->view;
        }

        return $this->render($view, $data);
    }

    public function render($view = null, $data = [])
    {
        $blade = new LaravelBlade($this->viewPath, $this->cache);

        return new HtmlString($blade->view()->make($view, array_merge($data, [
            'paginator' => $this,
            'elements'  => $this->elements(),
        ]))->render());
    }
}
