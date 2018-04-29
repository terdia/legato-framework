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
    
    public function __construct()
    {
        parent::__construct();
        $this->setArguments($this->argumentName, true, 'The controller name or path');
    }
    
}