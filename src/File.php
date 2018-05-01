<?php


namespace Legato\Framework;
use Symfony\Component\Filesystem\Filesystem;

class File
{
    public function getFileSystem()
    {
        return new Filesystem;
    }
}