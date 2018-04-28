<?php

namespace Legato\Framework;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Filesystem\Filesystem;

class CreateBasicConsoleCommand extends AbstractFileGenerator
{
    /**
     *
     * @var string
     */
    protected $commandName = 'add:command';
    
    protected $description = 'Create a console command';
    
    protected $basePath;
    
    public function __construct()
    {
        parent::__construct();
        $this->setArguments('CommandNameInput', true, 'The command class name or path');
    }
   
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $CommandNameInput = $input->getArgument('CommandNameInput');
        $commandFilePath = $this->basePath . '/' . $CommandNameInput . '.php';
        
        $result = $this->runFileGeneratorCommand($commandFilePath, $CommandNameInput);
        if($result === true){
            $output->writeln('Command created successfully');
            return;
        }
        $output->writeln($result);
    }
    
}