<?php

namespace Legato\Framework;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class Welcome extends Command
{
    /**
     * Identifier for the console command
     *
     * @var string
     */
    protected $commandName = 'welcome:greeting';

    /**
     * Command description
     *
     * @var string
     */
    protected $description = 'The Basic command Example';

    public function __construct($name = null)
    {
        parent::__construct($name);
    }

    public function execute(InputInterface $input, OutputInterface $output)
    {
        $output->writeln('Welcome to The Legato framework, build something.');
    }
}