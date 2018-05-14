<?php
namespace Framework\Tests;

use PHPUnit\Framework\TestCase;
use Legato\Framework\Validator\Validator;

class ValidationMessageTest extends TestCase
{


    /**
     * @test
     * @runInSeparateProcess
     */
    public function can_get_failed_validation_messages()
    {
        $failed_test_rules = [
            'username' => ['required' => true, 'min' => 10, 'max' => 70, 'alphaNum' => true],
            'ip_address' => ['required' => true, 'ip' => true],
            'link' => ['required' => true, 'url' => true],
        ];

        $custom = [
            'min' => 'Minimum length for username should be 10',
            'ip' => 'That address field must be a valid IP address'
        ];

        $failed_validator = new Validator(['username' => 'terdia_1', 'ip_address' => '45q.29.0.3',
            'link' => 'the_wrong_link'], $failed_test_rules, $custom);

        $pass = $failed_validator->fail();

        $this->assertTrue(true, $pass);

        $this->assertArrayHasKey('username', $failed_validator->error()->get());
        $this->assertArrayHasKey('ip_address', $failed_validator->error()->get());

        $this->assertSame('Minimum length for username should be 10',
            $failed_validator->error()->first('username'));

        $this->assertSame('That address field must be a valid IP address',
            $failed_validator->error()->first('ip_address'));

        $this->assertContains('The username field must be alphanumeric e.g. terdia07',
            $failed_validator->error()->get('username'));

        $this->assertContains('The link field must be a valid url',
            $failed_validator->error()->get('link'));
    }

}