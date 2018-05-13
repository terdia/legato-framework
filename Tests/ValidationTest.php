<?php
namespace Framework\Tests;

use Legato\Framework\Validator\Validator;
use PHPUnit\Framework\TestCase;

class ValidationTest extends TestCase
{

    /**
     * @test
     */
    public function can_get_failed_validation_messages()
    {
        $rules = [
            'username' => ['required' => true, 'min' => 10, 'max' => 70, 'alphaNum' => true],
            'ip_address' => ['required' => true, 'ip' => true],
            'link' => ['required' => true, 'url' => true],
        ];

        $custom = [
            'min' => 'Minimum length for username should be 10',
            'ip' => 'That address field must be a valid IP address'
        ];

        $validator = new Validator;
        $validator->create(['username' => 'terdia_1', 'ip_address' => '45q.29.0.3',
            'link' => 'the_wrong_link'], $rules, $custom);

        $pass = $validator->fail();

        $this->assertTrue(true, $pass);

        $this->assertArrayHasKey('username', $validator->error()->get());
        $this->assertArrayHasKey('ip_address', $validator->error()->get());

        $this->assertSame('Minimum length for username should be 10',
            $validator->error()->first('username'));

        $this->assertSame('That address field must be a valid IP address',
            $validator->error()->first('ip_address'));

        $this->assertContains('The username field must be alphanumeric e.g. terdia07',
            $validator->error()->get('username'));

        $this->assertContains('The link field must be a valid url',
            $validator->error()->get('link'));

    }

}