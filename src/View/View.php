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

abstract class View
{
    public $basePath;

    public $cache;

    public function __construct()
    {
        $this->basePath = $this->viewPath();
        $this->cache = $this->cachePath();
    }

    public function viewPath()
    {
        if (file_exists(realpath(__DIR__.'/../../../../../resources/views'))) {
            return realpath(__DIR__.'/../../../../../resources/views');
        }

        return realpath(__DIR__.'/../../resources/views');
    }

    public function cachePath()
    {
        if (file_exists(realpath(__DIR__.'/../../../../../resources/views'))) {
            return realpath(__DIR__.'/../../../../../cache/blade');
        }

        return realpath(__DIR__.'/../../cache/blade');
    }
}
