<?php

namespace Legato\Framework;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;

class StartApp extends Command
{
    /**
     * Identifier for the console command
     *
     * @var string
     */
    protected $commandName = 'start';

    /**
     * Command description
     *
     * @var string
     */
    protected $description = 'Start a local php development server';

    protected $hostname = 'localhost';

    protected $port = '8000';

    public function __construct($name = null)
    {
        parent::__construct($name);
        $this->setOption('hostname', null, true, 'Hostname e.g. example.com');
        $this->setOption('port', null, true, 'port to listen on e.g. 8000');
    }

   /**
    * You command logic
    *
    * @param InputInterface $input
    * @param OutputInterface $output
    * @return void
    */
   public function execute(InputInterface $input, OutputInterface $output)
   {
       chdir('public');

       /**
        * check for user supplied hostname option
        */

       if($input->hasOption('hostname') && $input->getOption('hostname') != NULL)
       {
           $this->hostname = $input->getOption('hostname');
       }

       /**
        * check for user supplied port option
        */
       if($input->hasOption('port') && $input->getOption('port') != NULL)
       {
           $this->port = $input->getOption('port');
       }

       $output->writeln("<info>Legato development server started</info>");
       $output->writeln("<info>Open your browser and navigate to: </info> <http://{$this->hostname}:{$this->port}>");
       $output->writeln("<info>CTRL C to quit </info>");
       passthru($this->startPHP());
   }

   public function startPHP()
   {
       return sprintf('%s -S %s:%s', 'php', $this->hostname, $this->port);
   }
}