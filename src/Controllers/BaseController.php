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

namespace Legato\Framework\Controllers;

use Legato\Framework\Request;

class BaseController
{
    protected $request;

    public function __construct(Request $request)
    {
        $this->request = $request;
    }
}
