<?php

namespace Falgun\Console;

interface CommandInterface
{
    public function getArgumentDefinitions(): array;

    /**
     * 
     * @param array $arguments
     * @return mixed Description
     */
    public function execute(array $arguments);
}
