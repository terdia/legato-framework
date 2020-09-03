<?php

/*
 * This file is part of the Legato package.
 *
 * (c) Osayawe Ogbemudia Terry <terry@devscreencast.com>
 *
 * For the full copyright and license information, please view the LICENSE
 *  file that was distributed with this source code.
 *
 */

namespace Legato\Framework\Console;

trait CommandTemplate
{
    /**
     * Get the template for creating a controller.
     *
     * @return bool|string
     */
    public function controller()
    {
        if ($this->restful) {
            return filesystem()->exists(realpath(__DIR__.'/../../../../../app/controllers')) ?
                realpath(__DIR__.'/../Templates/controller/restful.stub') :
                realpath(__DIR__.'/../Templates/controller/restful.core.stub');
        }

        return filesystem()->exists(realpath(__DIR__.'/../../../../../app/controllers')) ?
            realpath(__DIR__.'/../Templates/controller/plain.stub') :
            realpath(__DIR__.'/../Templates/controller/core.stub');
    }

    public function model()
    {
        return filesystem()->exists(realpath(__DIR__.'/../../../../../app/models')) ?
            realpath(__DIR__.'/../Templates/model/plain.stub') :
            realpath(__DIR__.'/../Templates/model/core.stub');
    }

    public function command()
    {
        return filesystem()->exists(realpath(__DIR__.'/../../../../../app/commands')) ?
            realpath(__DIR__.'/../Templates/commands/basic.stub') :
            realpath(__DIR__.'/../Templates/commands/core_basic.stub');
    }

    public function test()
    {
        return filesystem()->exists(realpath(__DIR__.'/../../../../../tests')) ?
            realpath(__DIR__.'/../Templates/test/phpunit.stub') :
            (__DIR__.'/../Templates/test/core.stub');
    }
}
