<?php
namespace Framework\Tests;

use Legato\Framework\WelcomeCommand;
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
        $app = new Application;
        $app->add(new WelcomeCommand);
        $command = $app->find('welcome:greet');
        
        $symphonyCommandTester = new CommandTester($command);
        $symphonyCommandTester->execute([]);
        
        $this->assertSame('Welcome to the Legato Framework', $symphonyCommandTester->getDisplay());
    }

}