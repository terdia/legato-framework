<?php
namespace Legato\Framework;

interface TemplateGenerator
{
    /**
     * Get the stub for the file to be generated
     *
     * @return mixed
     */
    public function getTemplate();
    
    /**
     * @param $search
     * @param $replace
     * @param $target
     * @return mixed
     */
    public function findTemplateAndReplacePlaceHolders($search, $replace, $target);
}