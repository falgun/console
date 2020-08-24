<?php
declare(strict_types=1);

namespace Falgun\Console;

use Falgun\Console\CommandInterface;
use Falgun\Console\Exception\CommandNotFoundException;

class Application
{

    protected string $name;
    protected string $version;
    protected array $commands;
    protected array $aliases;
//    protected array $argv;

    public final function __construct(string $name, string $version)
    {
        $this->name = $name;
        $this->version = $version;
        $this->commands = [];
        $this->aliases = [];
    }

    public function execute(array $argv)
    {
        // remove first one, because its cli file name
        array_shift($argv);
//        $this->argv = $argv;

        $commandName = array_shift($argv);

        if (isset($this->commands[$commandName])) {
            $commandClass = $this->commands[$commandName];

            $command = new $commandClass();

            $definitions = $this->prepareArgumentDefinitions($command);

            $arguments = (new ArgvParser)->parse($definitions, $argv);


            return $command->execute($arguments);
        }

        throw new CommandNotFoundException($commandName . ': Command Not Found');
    }

    protected function prepareArgumentDefinitions(CommandInterface $command): array
    {

        $definitionsArr = $command->getArgumentDefinitions();
        $definitions = [];

        foreach ($definitionsArr as $definition) {
            $argName = $definition->getName();

            $definitions[$argName] = $definition;
        }

        return $definitions;
    }

    public function registerCommands(array $commands): void
    {
        foreach ($commands as $command) {
            $this->addCommand($command);
        }
    }

    public function addCommand(string $command): void
    {
        if (\class_exists($command) === false) {
            throw new CommandNotFoundException($command . ': Command Class Not Found');
        }

        $name = $command::NAME;

        $this->commands[$name] = $command;
    }

    public function getCommands(): array
    {
        return $this->commands;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getVersion(): string
    {
        return $this->version;
    }

    public function getAliases(): array
    {
        return $this->aliases;
    }

    public function setName(string $name): self
    {
        $this->name = $name;
        return $this;
    }

    public function setVersion(string $version): self
    {
        $this->version = $version;
        return $this;
    }

    public function setAliases(array $aliases): self
    {
        $this->aliases = $aliases;
        return $this;
    }
}
