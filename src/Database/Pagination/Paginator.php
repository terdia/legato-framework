<?php


namespace Legato\Framework;
use Illuminate\Pagination\Paginator as LaraPaginator;
use Illuminate\Support\HtmlString;
use Philo\Blade\Blade as LaravelBlade;

class Paginator extends LaraPaginator
{
    protected $viewPath = __DIR__ . '/views';
    protected $cache = __DIR__ . '/cache';
    protected $view = 'simple-bootstrap-4';

    public function links($view = null, $data = [])
    {
        if(is_null($view)) {
            $view = $this->view;
        }
        return $this->render($view, $data);
    }

    public function render($view = null, $data = [])
    {
        $blade = new LaravelBlade($this->viewPath, $this->cache);

        return new HtmlString($blade->view()->make($view, array_merge($data, [
            'paginator' => $this,
        ]))->render());
    }
}