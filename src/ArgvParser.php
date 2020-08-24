<?php
declare(strict_types=1);

namespace Falgun\Console;

use Falgun\Console\Argument;
use Falgun\Console\Exception\UndefinedArgumentException;
use Falgun\Console\Exception\ArgumentRequiredException;

class ArgvParser
{

    public final function __construct()
    {
        
    }

    public function parse(array $definitions, array $argv): array
    {
        $arguments = [];

        $totalArgv = count($argv);
        for ($i = 0; $i < $totalArgv; $i++) {
            if (isset($argv[$i]) === false) {
                break;
            }

            $arg = $argv[$i];

            if (isset($definitions[$arg]) === false) {
                throw new UndefinedArgumentException($arg);
            }

            /** @var Argument $definition */
            $definition = $definitions[$arg];

            if ($definition->isFlag() === false) {
                //has value

                $value = $argv[++$i];

                $arguments[$definition->getName()] = $value;
            } else {
                $arguments[$definition->getName()] = true;
            }
        }

        return $this->prepareArguments($definitions, $arguments);
    }

    protected function prepareArguments(array $definitions, array $arguments): array
    {
        /** @var Argument $definition */
        foreach ($definitions as $definition) {
            if ($definition->isRequired() &&
                $definition->hasDefaultValue() == false &&
                isset($arguments[$definition->getName()]) === false) {
                // required argument is absent
                throw new ArgumentRequiredException($definition->getName());
            }

            if ($definition->hasDefaultValue() && isset($arguments[$definition->getName()]) === false) {
                // value not provided
                // assign default value
                $arguments[$definition->getName()] = $definition->getDefaultValue();
            }
        }

        return $arguments;
    }
}
