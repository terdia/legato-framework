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

class Create
{
    private $defaultCommands = [
        \Legato\Framework\CreateController::class,
        \Legato\Framework\CreatePhpUnitTest::class,
        \Legato\Framework\CreateBasicConsoleCommand::class,
        \Legato\Framework\WelcomeCommand::class,
        \Legato\Framework\CreateModel::class,
        \Legato\Framework\StartPhpInbuiltServer::class,
    ];

    public $app;

    public function __construct()
    {
        $this->app = new Legato();
        $this->app->registerCommands(array_merge($this->defaultCommands, $this->getCommands()));
    }

    public function getCommands()
    {
        if (file_exists(realpath(__DIR__.'/../../../../../app/commands/register.php'))) {
            return require_once realpath(__DIR__.'/../../../../../app/commands/register.php');
        }

        return [];
    }
}
