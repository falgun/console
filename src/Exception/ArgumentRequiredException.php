<?php
declare(strict_types=1);

namespace Falgun\Console\Exception;

class ArgumentRequiredException extends \Exception
{

    public function __construct(string $argumentName, int $code = 0, \Throwable $previous = NULL)
    {
        parent::__construct($argumentName . ' is required but not given.', $code, $previous);
    }
}
