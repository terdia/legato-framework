<?php

namespace Legato\Framework;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Filesystem\Filesystem;

class CreatePhpUnitTest extends Command
{
    /**
     *
     * @var string
     */
    protected $commandName = 'add:unitTest';
    
    protected $description = 'Create a new phpunit test class';
    
    protected $filesystem;
    
    private $basePath;
    
    public function __construct($name = null)
    {
        parent::__construct($name);
        $this->setArguments('className', true, 'The phpunit filename or path');
        $this->filesystem = new Filesystem;
        $this->basePath = $this->getBasePath();
    }
    
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $argument = $input->getArgument('className');
        $path = $this->basePath . '/' . $argument . '.php';
        
        if($this->filesystem->exists($path)){
            $output->writeln( $argument . ' test already exist');
            return false;
        }
        
        $folder_name = explode('/', $argument);
        $folder = '';
        
        if(count($folder_name) > 1){
            $folder_path = array_slice($folder_name, 0, -1);
            
            foreach ($folder_path as $f){
                $folder .= "$f/";
            }
            
            $filename = end($folder_name);
            
        }else{
            $filename = $argument;
        }
        
        $folder ? $controller = "$this->basePath/$folder/$filename.php":
            $controller = "$this->basePath/$filename.php";
        
        $template = $this->findTemplateAndReplacePlaceHolders('DummyTest',
            $filename,
            file_get_contents($this->getTemplate())
        );
        
        $this->filesystem->dumpFile($controller, $template);
        $output->writeln("$filename created successfully");
        return true;
    }
    
    /**
     * Define and return the base path for controller
     *
     * @return bool|string
     */
    private function getBasePath()
    {
        if($this->filesystem->exists(realpath(__DIR__ . '/../../../../../tests'))){
            return __DIR__ . '/../../../../../tests';
        }
        
        return realpath(__DIR__ . '/../../Tests');
    }
    
    /**
     * Get the template for creating a new controller
     *
     * @return string
     */
    protected function getTemplate()
    {
        if($this->filesystem->exists(realpath(__DIR__ . '/../../../../../tests'))){
            return __DIR__ . '/../Templates/test/phpunit.stub';
        }
        
        return __DIR__ . '/../Templates/test/core.stub';
    }
    
    /**
     * @param $search
     * @param $replace
     * @param $target
     * @return mixed
     */
    protected function findTemplateAndReplacePlaceHolders($search, $replace, $target)
    {
        return str_replace($search, $replace, $target);
    }
}