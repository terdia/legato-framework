<?php
namespace Legato\Framework\Controllers;

use Legato\Framework\Request;
use GuzzleHttp\Client;
use Symfony\Component\HttpFoundation\Session\Session;

class BaseController
{
    protected $request;
    protected $session;
    protected $client;

    public function __construct(Request $request, Session $session)
    {
        $this->request = $request;
        $this->session = $session;
        $this->client = new Client;
    }

}