<?php
namespace Legato\Framework;

use Symfony\Component\Console\Application;

class Legato
{
    protected $console;
    
    public function __construct($name = 'Legato', $version = 'v1')
    {
        $this->console = new Application($name, $version);
    }
    
    /**
     * Register user defined commands
     *
     * @param array $commands
     */
    public function registerCommands(array $commands)
    {
        foreach ($commands as $command)
        {
            $this->console->add(new $command);
        }
    }
    
    /**
     * Start the console application
     */
    public function start()
    {
        $this->console->run();
    }
}
