<?php

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
