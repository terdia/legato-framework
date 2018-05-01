<?php

namespace Legato\Framework;

class CreateBasicConsoleCommand extends AbstractFileGenerator
{
    /**
     *
     * @var string
     */
    protected $commandName = 'add:command';
    
    protected $description = 'Create a console command';
    
    protected $basePath;
    
    protected $type = 'command';
    
    public function __construct()
    {
        parent::__construct();
        $this->setArguments($this->argumentName, true, 'The command class name or path');
    }
}