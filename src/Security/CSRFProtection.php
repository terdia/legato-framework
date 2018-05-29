<?php

namespace Legato\Framework\Security;

use Legato\Framework\Request;

class CSRFProtection
{
    protected $request;

    /**
     * URI that the developer choose to skip CSRF Verification for
     * e.g /thanks which should match your route target.
     *
     * @var array
     */
    protected $skipValidation = [];

    public function __construct(Request $request)
    {
        $this->request = $request;
    }

    /**
     * Run CSRF Validation verification.
     *
     * @throws TokenMisMatchException
     *
     * @return bool
     */
    public function handle()
    {
        return $this->validate();
    }

    /**
     * Validate POST | PUT | PATCH request token.
     *
     * @throws TokenMisMatchException
     *
     * @return bool
     */
    protected function validate()
    {
        if ($this->isSafeRequest() || $this->isAllowedByDeveloper() || $this->verify()) {
            return true;
        }

        throw new TokenMisMatchException('CSRF Token validation Failed');
    }

    /**
     * Verify CSRF Token.
     */
    protected function verify()
    {
        $token = $this->extractToken();

        return hash_equals($this->tokenFromStorage(), (string) $token);
    }

    /**
     * extract token from form or JavaScript Clients like Axios, Ajax, JQuery.
     *
     * @return bool|string|string[]
     */
    protected function extractToken()
    {
        if ($this->request->input('token') === false) {
            if (!$this->request->getHeader('X-JS-CLIENTS-TOKEN')) {
                return 'token';
            }

            return $this->request->getHeader('X-JS-CLIENTS-TOKEN');
        }

        return $this->request->input('token');
    }

    /**
     * Check if URI does not require CSRF Validation.
     */
    protected function isAllowedByDeveloper()
    {
        return in_array($this->request->uri(), $this->skipValidation);
    }

    /**
     * Methods for viewing resources 'HEAD', 'GET', 'OPTIONS' and Unit
     * test does not require CSRF Validation such methods are considered safe.
     *
     * @return bool
     */
    protected function isSafeRequest()
    {
        return in_array($this->request->method(), ['HEAD', 'GET', 'OPTIONS'])
            || $this->isTestMode();
    }

    /**
     * Get the generate token from storage.
     *
     * @return mixed|string
     */
    protected function tokenFromStorage()
    {
        if ($this->request->session()->has('token')) {
            return $this->request->session()->get('token');
        }

        return 'nothing';
    }

    /**
     * Determine if application is running from test mode.
     *
     * @return bool
     */
    protected function isTestMode()
    {
        if (isRunningFromConsole() && (defined('PHPUNIT_RUNNING') && PHPUNIT_RUNNING == true)) {
            return true;
        }

        return false;
    }
}
