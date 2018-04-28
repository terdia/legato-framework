<?php

namespace Legato\Framework;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Filesystem\Filesystem;

class CreatePhpUnitTest extends AbstractFileGenerator
{
    /**
     *
     * @var string
     */
    protected $commandName = 'add:unitTest';
    protected $description = 'Create a new phpunit test class';
    protected $basePath;
    
    protected $type = 'test';
    
    public function __construct()
    {
        parent::__construct();
        $this->setArguments('testNameInput', true, 'The phpunit filename or path');
    }
    
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $testNameInput = $input->getArgument('testNameInput');
        $filePath = $this->basePath . '/' . $testNameInput . '.php';
        $response = $this->runFileGeneratorCommand($filePath, $testNameInput);
        
        if($response === true){
            $output->writeln('Test created successfully');
            return;
        }
        $output->writeln($response);
    }
}