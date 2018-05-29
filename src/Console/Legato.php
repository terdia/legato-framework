<?php

namespace Legato\Framework;

use Symfony\Component\Console\Application;

class Legato
{
    protected $console;

    public function __construct()
    {
        $this->console = new Application(App::NAME, App::VERSION);
    }

    /**
     * Register user defined commands.
     *
     * @param array $commands
     */
    public function registerCommands(array $commands)
    {
        foreach ($commands as $command) {
            $this->console->add(new $command());
        }
    }

    /**
     * Start the console application.
     *
     * @throws \Exception
     */
    public function start()
    {
        $this->console->run();
    }
}
