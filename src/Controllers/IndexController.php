<?php

namespace Legato\Framework\Controllers;

class IndexController extends BaseController
{
    public function show()
    {
        return view('home');
    }
}
