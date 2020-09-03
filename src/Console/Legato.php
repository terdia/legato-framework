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

namespace Legato\Framework\Console;

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
