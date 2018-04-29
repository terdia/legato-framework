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
    
    /**
     * Type of file to be generated
     * @var string
     */
    protected $type = 'test';
    
    public function __construct()
    {
        parent::__construct();
        $this->setArguments($this->argumentName, true, 'The phpunit filename or path');
    }
}