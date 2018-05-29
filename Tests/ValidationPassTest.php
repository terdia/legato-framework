<?php

namespace Framework\Tests;

use Legato\Framework\Validator\Validator;
use PHPUnit\Framework\TestCase;

class ValidationPassTest extends TestCase
{
    /**
     * @test
     */
    public function validation_passes()
    {
        $rules = [
            'username'    => ['required' => true, 'min' => 10, 'max' => 70, 'alphaNum' => true],
            'ip_address'  => ['required' => true, 'ip' => true],
            'website_url' => ['required' => true, 'url' => true],
            'email'       => ['required' => true, 'email' => true],
            'code'        => ['required' => true, 'numeric' => true],
            'price'       => ['required' => true, 'float' => true],
            'fullname'    => ['required' => true, 'string' => true],
            'tag'         => ['required' => true, 'alpha' => true, 'max' => 20],
            'special'     => ['required' => true, 'mixed' => true],
        ];

        $data = [
            'username'    => 'terry', 'ip_address' => '192.168.0.2',
            'website_url' => 'legatoframework.com',
            'email'       => 'terry@devscreencast.com',
            'code'        => '9873',
            'price'       => 49.8,
            'fullname'    => 'Osayawe Ogbemudia Terry',
            'tag'         => 'validation',
            'special'     => "That's car, parked over there",
        ];

        $validator = new Validator($data, $rules);

        $this->assertFalse(false, $validator->fail());
    }
}
