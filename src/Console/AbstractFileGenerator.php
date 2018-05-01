<?php


namespace Legato\Framework;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Filesystem\Filesystem;

class AbstractFileGenerator extends Command implements TemplateGenerator
{
    use CommandTemplate, FileGeneratorPath;
    
    protected $filesystem;
    
    /**
     * Type of file to be generated
     * @var string
     */
    protected $type;
    
    protected $basePath;
    
    /**
     * Argument identifier (name)
     * @var string
     */
    protected $argumentName = 'className';
    
    public function __construct()
    {
        parent::__construct();
        
        if(property_exists(self::class, 'filesystem'))
        {
            $this->filesystem = new Filesystem;
        }
    
        if(property_exists(self::class, 'basePath'))
        {
            $this->basePath = $this->getBasePath($this->type);
        }
    }
    
    /**
     * Get the stub for the file to be generated
     *
     * @param $type
     * @return mixed
     */
    public function getTemplate($type = 'command')
    {
        return call_user_func([$this, $type]);
    }
    
    /**
     * @param $search
     * @param $replace
     * @param $target
     * @return mixed
     */
    public function findTemplateAndReplacePlaceHolders($search, $replace, $target)
    {
        return str_replace($search, $replace, $target);
    }
    
    /**
     * Define and return the base path for controller
     * @param $type
     * @return bool|string
     */
    protected function getBasePath($type = 'command')
    {
        return call_user_func([$this, 'get'.ucfirst($type).'Path']);
    }
    
    /**
     * Generate and move file to specified path
     *
     * @param $path
     * @param $argument
     * @return string
     */
    public function runFileGeneratorCommand($path, $argument)
    {
        if($this->filesystem->exists($path)){
            return 'File with the name '.$argument . ' already exist';
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
        $folder ? $location = "$this->basePath/$folder/$filename.php" : $location = "$this->basePath/$filename.php";
        $template = $this->findTemplateAndReplacePlaceHolders('PlaceHolder', $filename,
            file_get_contents($this->getTemplate($this->type))
        );
        $this->filesystem->dumpFile($location, $template);
        return true;
    }
    
    public function execute(InputInterface $input, OutputInterface $output)
    {
        $argument = $input->getArgument($this->argumentName);
        $path = $this->basePath . '/' . $argument . '.php';
        $response = $this->runFileGeneratorCommand($path, $argument);
        
        if($response === true){
            $this->type ?: $this->type = "Command";
            $output->writeln(ucfirst($this->type).' created successfully');
            return;
        }
        $output->writeln($response);
    }
}