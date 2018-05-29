<?php

namespace Legato\Framework;

trait FileGeneratorPath
{
    public function getControllerPath()
    {
        return filesystem()->exists(realpath(__DIR__.'/../../../../../app/controllers')) ?
            realpath(__DIR__.'/../../../../../app/controllers') : realpath(__DIR__.'/../Controllers');
    }

    public function getModelPath()
    {
        return filesystem()->exists(realpath(__DIR__.'/../../../../../app/models')) ?
            realpath(__DIR__.'/../../../../../app/models') : realpath(__DIR__.'/../Models');
    }

    public function getCommandPath()
    {
        return filesystem()->exists(realpath(__DIR__.'/../../../../../app/commands')) ?
            realpath(__DIR__.'/../../../../../app/commands') : realpath(__DIR__.'/../Console');
    }

    public function getTestPath()
    {
        return filesystem()->exists(realpath(__DIR__.'/../../../../../tests')) ?
            realpath(__DIR__.'/../../../../../tests') : realpath(__DIR__.'/../../Tests');
    }
}
