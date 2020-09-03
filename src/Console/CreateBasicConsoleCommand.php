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

class CreateBasicConsoleCommand extends AbstractFileGenerator
{
    /**
     * @var string
     */
    protected $commandName = 'add:command';

    protected $description = 'Create a console command';

    protected $basePath;

    protected $type = 'command';

    public function __construct()
    {
        parent::__construct();
        $this->setArguments($this->argumentName, true, 'The command class name or path');
    }
}
