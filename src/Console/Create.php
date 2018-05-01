<?php

namespace Legato\Framework;

class Create
{
    private $defaultCommands = [
        \Legato\Framework\CreateController::class,
        \Legato\Framework\CreatePhpUnitTest::class,
        \Legato\Framework\CreateBasicConsoleCommand::class,
        \Legato\Framework\WelcomeCommand::class,
    ];
    
    public $app;
    
    public function __construct()
    {
        $this->app = new Legato();
        $this->app->registerCommands(array_merge($this->defaultCommands, $this->getCommands()));
    }
    
    public function getCommands()
    {
        if(file_exists(realpath(__DIR__ . '/../../../../../app/commands/register.php'))){
            return require_once realpath(__DIR__ . '/../../../../../app/commands/register.php');
        }
        return [];
    }
}