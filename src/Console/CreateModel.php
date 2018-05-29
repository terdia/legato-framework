<?php

namespace Legato\Framework;

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
