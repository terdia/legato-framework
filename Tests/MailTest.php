<?php
namespace Framework\Tests;

use Legato\Framework\Mail\Mail;
use PHPUnit\Framework\TestCase;

class MailTest extends TestCase
{

    /**
     * @test
     */
    public function create_something()
    {
        $this->assertTrue(true);
    }

    /**
     * @test
     */
    /*public function can_send_email_with_user_selected_driver()
    {

        $file = __DIR__.'/../phpunit-book.pdf';

        $params = [
            'to' => ['to_email' => 'Legato Framework'],
            'from' => ['no-reply@devscreencast.com' => 'Devscreencast, Inc'],
            'subject' => 'Testing from Legato Framework',
            'body' => ['address' => '20 Dawson road', 'name' => 'Jake Pattern'],
            'view' => 'emails/welcome.blade.php',
            'file' => $file
        ];

        $result = Mail::send($params);
        $driver = Mail::$driver;

        if($driver == 'smtp'){
            $this->assertEquals(1, $result);
        }else{
            $this->assertSame('Queued. Thank you.', $result->message);
        }

    }*/

}