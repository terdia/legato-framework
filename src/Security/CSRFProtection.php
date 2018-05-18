<?php


namespace Legato\Framework\Security;


use Legato\Framework\Request;

class CSRFProtection
{
    protected $request;

    /**
     * URI that the developer choose to skip CSRF Verification for
     * e.g /thanks which should match your route target
     * @var array
     */
    protected $skipValidation = [];

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Validate POST | PUT | PATCH request token
     *
     * @return bool
     * @throws TokenMisMatchException
     */
    public function validate()
    {

        if($this->isSafeRequest() || $this->isAllowedByDeveloper() || $this->verify())
        {
            return true;
        }

        throw new TokenMisMatchException('CSRF Token validation Failed');
    }

    /**
     * Verify CSRF Token
     */
    public function verify()
    {
        $token = $this->extractToken();

        return hash_equals($this->tokenFromStorage(), (string) $token);
    }

    /**
     * extract token from form or JavaScript Clients like Axios, Ajax, JQuery
     *
     * @return bool|string|string[]
     */
    public function extractToken()
    {
        if($this->request->input('token') === false) {
            if( !$this->request->getHeader('X-JS-CLIENTS-TOKEN') ){
                return 'token';
            }
            return $this->request->getHeader('X-JS-CLIENTS-TOKEN');
        }
        return $this->request->input('token');
    }

    /**
     * Check if URI does not require CSRF Validation
     */
    public function isAllowedByDeveloper()
    {
        return in_array($this->request->uri(), $this->skipValidation);
    }

    /**
     * Methods for viewing resource don't require CSRF Validation
     * such methods are considered safe
     *
     * @return bool
     */
    public function isSafeRequest()
    {
        return in_array($this->request->method(), ['HEAD', 'GET', 'OPTIONS']) ||
            (php_sapi_name() == 'cli' || php_sapi_name() == 'phpdbg');
    }

    /**
     * Get the generate token from storage
     *
     * @return mixed|string
     */
    public function tokenFromStorage()
    {
        if($this->request->session()->has('token')){
            return $this->request->session()->get('token');
        }

        return 'nothing';
    }

}