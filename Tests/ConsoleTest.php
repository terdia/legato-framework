<?php

/*
 * This file is part of the Legato package.
 *
 * (c) Osayawe Ogbemudia Terry <terry@devscreencast.com>
 *
 * For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 *
 */

namespace Framework\Tests;

use Legato\Framework\Console\WelcomeCommand;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Console\Application;
use Symfony\Component\Console\Tester\CommandTester;

class ConsoleTest extends TestCase
{
    /**
     * @test
     */
    public function welcomeCommand()
    {
        $app = new Application();
        $app->add(new WelcomeCommand());
        $command = $app->find('welcome:greet');

        $symphonyCommandTester = new CommandTester($command);
        $symphonyCommandTester->execute([]);

        $this->assertSame('Welcome to the Legato Framework', $symphonyCommandTester->getDisplay());
    }

    /**
     * @test
     */
    public function can_exempt_unit_test_from_csrf_verification()
    {
        $test = false;
        $console = isRunningFromConsole();

        $this->assertSame(true, $console);

        if (defined('PHPUNIT_RUNNING')) {
            $test = PHPUNIT_RUNNING;
        }

        $this->assertSame(true, $test);
    }
}
