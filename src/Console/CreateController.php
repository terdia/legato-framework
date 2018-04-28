<?php

namespace Legato\Framework;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Filesystem\Filesystem;

class CreateController extends AbstractFileGenerator
{
    /**
     *
     * @var string
     */
    protected $commandName = 'add:controller';
    
    /**
     * Description for thi command
     * @var string
     */
    protected $description = 'Create a controller class';
    
    protected $basePath;
    
    protected $type = 'controller';
    
    public function __construct($name = null)
    {
        parent::__construct();
        $this->setArguments('className', true, 'The controller name or path');
    }
    
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $controllerArgument = $input->getArgument('className');
        $path = $this->basePath . '/' . $controllerArgument . '.php';
        $response = $this->runFileGeneratorCommand($path, $controllerArgument);
        
        if($response === true){
            $output->writeln('Controller created successfully');
            return;
        }
        $output->writeln($response);
    }
    
}