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

use Symfony\Component\Console\Command\Command as SymfonyCommand;
use Symfony\Component\Console\Input\InputArgument;
use Symfony\Component\Console\Input\InputOption;

abstract class Command extends SymfonyCommand
{
    /**
     * Identifier for the console command.
     *
     * @var string
     */
    protected $commandName;

    /**
     * Command description.
     *
     * @var string
     */
    protected $description;

    public function __construct($name = null)
    {
        parent::__construct($name);
        $this->setName($this->commandName);
        $this->setDescription($this->description);
    }

    /**
     * Add argument to a command.
     *
     * @param $name, the argument name
     * @param bool   $required,   is it required
     * @param string $description
     */
    public function setArguments($name, $required = false, $description = 'Argument description')
    {
        $required ? $required = InputArgument::REQUIRED : $required = InputArgument::OPTIONAL;
        $this->addArgument($name, $required, $description);
    }

    /**
     * Add options to command.
     *
     * @param $name, the option name
     * @param null $shortcut
     * @param bool $inputRequired, whether it is required
     * @param $description, description
     */
    public function setOption($name, $shortcut = null, $inputRequired = false, $description = 'option does what?')
    {
        $inputRequired ? $inputRequired = InputOption::VALUE_REQUIRED :
            $inputRequired = InputOption::VALUE_OPTIONAL;

        $this->addOption($name, $shortcut, $inputRequired, $description);
    }
}
