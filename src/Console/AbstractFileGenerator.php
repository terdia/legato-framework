<?php


namespace Legato\Framework;

use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Filesystem\Filesystem;

class AbstractFileGenerator extends Command implements TemplateGenerator
{
    protected $filesystem;
    protected $type;
    protected $basePath;
    
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
    public function getTemplate($type = null)
    {
        switch ($type){
            case 'controller':
                return $this->filesystem->exists(realpath(__DIR__ . '/../../../../../app/controllers')) ?
                    realpath(__DIR__ . '/../Templates/controller/plain.stub') :
                    realpath(__DIR__ . '/../Templates/controller/core.stub');
                break;
            case 'test':
                return $this->filesystem->exists(realpath(__DIR__ . '/../../../../../tests')) ?
                    realpath(__DIR__ . '/../Templates/test/phpunit.stub') :
                    (__DIR__ . '/../Templates/test/core.stub');
                break;
            default:
                return $this->filesystem->exists(realpath(__DIR__ . '/../../../../../app/commands')) ?
                    realpath(__DIR__ . '/../Templates/commands/basic.stub') :
                    realpath(__DIR__ . '/../Templates/commands/core_basic.stub');
        }
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
    protected function getBasePath($type = null)
    {
        switch ($type){
            case 'controller':
                return $this->filesystem->exists(realpath(__DIR__ . '/../../../../../app/controllers')) ?
                   realpath(__DIR__ . '/../../../../../app/controllers') : realpath(__DIR__ . '/../Controllers');
                break;
            case 'test':
                return $this->filesystem->exists(realpath(__DIR__ . '/../../../../../tests')) ?
                    realpath(__DIR__ . '/../../../../../tests') : realpath(__DIR__ . '/../../Tests');
                break;
            default:
                return $this->filesystem->exists(realpath(__DIR__ . '/../../../../../app/commands')) ?
                    realpath(__DIR__ . '/../../../../../app/commands') : realpath(__DIR__ . '/../Console');
        }
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
}