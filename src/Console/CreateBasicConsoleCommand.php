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
        $this->setArguments($this->argumentName, true, 'The command class name or path');
    }
}