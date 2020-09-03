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

class StartPhpInbuiltServer extends Command
{
    /**
     * Identifier for the console command.
     *
     * @var string
     */
    protected $commandName = 'start';

    /**
     * Command description.
     *
     * @var string
     */
    protected $description = 'Start a local php development server';

    protected $hostname = 'localhost';

    protected $port = '8000';

    protected $phpexec = 'php';

    public function __construct($name = null)
    {
        parent::__construct($name);
        $this->setOption('hostname', null, true, 'Hostname e.g. example.com');
        $this->setOption('port', null, true, 'port to listen on e.g. 8000');
        $this->setOption('path', null, true, 'path to your php executable e.g. /usr/bin/php');
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
        chdir('public');

        /*
         * check for user supplied hostname option
         */
        if ($input->hasOption('hostname') && $input->getOption('hostname') != null) {
            $this->hostname = $input->getOption('hostname');
        }

        /*
         * check for user supplied port option
         */
        if ($input->hasOption('port') && $input->getOption('port') != null) {
            $this->port = $input->getOption('port');
        }

        /*
         * check for user supplied a path option
         */
        if ($input->hasOption('path') && $input->getOption('path') != null) {
            $this->phpexec = $input->getOption('path');
        }

        $output->writeln('<info>Legato development server started</info>');
        $output->writeln("<info>Open your browser and navigate to: </info> <http://{$this->hostname}:{$this->port}>");
        $output->writeln('<info>CTRL C to quit </info>');
        passthru($this->startPHP());
    }

    /**
     * Start a local dev PHP Server.
     *
     * @return string
     */
    public function startPHP()
    {
        return sprintf('%s -S %s:%s', $this->phpexec, $this->hostname, $this->port);
    }
}
