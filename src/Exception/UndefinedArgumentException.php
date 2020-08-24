<?php
declare(strict_types=1);

namespace Falgun\Console\Exception;

class UndefinedArgumentException extends \Exception
{

    public function __construct(string $argumentName, int $code = 0, \Throwable $previous = NULL)
    {
        parent::__construct($argumentName . ' is not registered', $code, $previous);
    }
}
