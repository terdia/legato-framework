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

class CreateController extends AbstractFileGenerator
{
    /**
     * @var string
     */
    protected $commandName = 'add:controller';

    /**
     * Description for thi command.
     *
     * @var string
     */
    protected $description = 'Create a controller class';

    protected $basePath;

    protected $type = 'controller';

    protected $restful = false;

    public function __construct()
    {
        parent::__construct();
        $this->setArguments($this->argumentName, true, 'The controller name or path');
        $this->setOption('restful', null, false, 'create a restful controller');
    }
}
