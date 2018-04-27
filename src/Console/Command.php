<?php


namespace Legato\Framework;
use Symfony\Component\Console\Command\Command as SymfonyCommand;
use Symfony\Component\Console\Input\Input;
use Symfony\Component\Console\Input\InputArgument;

abstract class Command extends SymfonyCommand
{
    /**
     * Identifier for the console command
     *
     * @var string
     */
    protected $commandName;
    
    /**
     * Command description
     *
     * @var string
     */
    protected $description;
    
    public function __construct($name = null)
    {
        parent::__construct($name);
        $this->setName($this->commandName);
        $this->setDescription($this->description);
    }
    
    public function setArguments($name, $required = false, $description = 'Argument description')
    {
        if($required){
            $required = InputArgument::REQUIRED;
        }else{
            $required = InputArgument::OPTIONAL;
        }
        $this->addArgument($name, $required, $description);
    }
}