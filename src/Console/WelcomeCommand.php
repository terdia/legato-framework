<?php

namespace Legato\Framework;

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
     * @param InputInterface $input
     * @param OutputInterface $output
     *
     * @return void
     */
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $output->write('Welcome to the Legato Framework');
    }
}
