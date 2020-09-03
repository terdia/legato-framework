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

class CreateModel extends AbstractFileGenerator
{
    /**
     * @var string
     */
    protected $commandName = 'add:model';

    protected $description = 'Create a database model';

    protected $type = 'model';

    protected $basePath;

    public function __construct()
    {
        parent::__construct();
        $this->setArguments($this->argumentName, true, 'The model name or path');
    }
}
