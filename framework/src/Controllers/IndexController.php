<?php
namespace Legato\Framework\Controllers;
use Legato\Framework\Session\SessionManager;

class IndexController extends BaseController
{
    use SessionManager;

    public function show()
    {
        return view('home.twig');
    }
}