<?php
namespace Legato\Framework;

interface TemplateGenerator
{
    /**
     * Get the stub for the file to be generated
     *
     * @param $type
     * @return mixed
     */
    public function getTemplate($type = null);
    
    /**
     * @param $search
     * @param $replace
     * @param $target
     * @return mixed
     */
    public function findTemplateAndReplacePlaceHolders($search, $replace, $target);
}