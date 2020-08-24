<?php
declare(strict_types=1);

namespace Falgun\Console\Tests\Commands;

use Falgun\Console\Argument;
use Falgun\Console\CommandInterface;

class LsCommand implements CommandInterface
{

    public const NAME = 'ls';

    public function getArgumentDefinitions(): array
    {
        return [
            (new Argument('name'))->required(),
            (new Argument('age'))->defaultValue('10'),
            (new Argument('good'))->asFlag(),
        ];
    }

    public function execute(array $arguments)
    {
        return $arguments;
    }
}
