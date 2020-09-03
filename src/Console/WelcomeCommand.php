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

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class WelcomeCommand extends Command
{
    /**
     * Identifier for the console command.
     *
     * @var string
     */
    protected $commandName = 'welcome:greet';

    /**
     * Command description.
     *
     * @var string
     */
    protected $description = 'The command description';

    public function __construct($name = null)
    {
        parent::__construct($name);
    }

    /**
     * You command logic.
     *
     * @param InputInterface  $input
     * @param OutputInterface $output
     *
     * @return void
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $output->write('Welcome to the Legato Framework');
    }
}
