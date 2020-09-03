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

class CreatePhpUnitTest extends AbstractFileGenerator
{
    /**
     * @var string
     */
    protected $commandName = 'add:unitTest';

    protected $description = 'Create a new phpunit test class';

    protected $basePath;

    /**
     * Type of file to be generated.
     *
     * @var string
     */
    protected $type = 'test';

    public function __construct()
    {
        parent::__construct();
        $this->setArguments($this->argumentName, true, 'The phpunit filename or path');
    }
}
