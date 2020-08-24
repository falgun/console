<?php
declare(strict_types=1);

namespace Falgun\Console;

class Argument
{

    protected string $name;
    protected bool $required;
    protected $default;
    protected bool $flag;

    public function __construct(string $name)
    {
        $this->name = $name;
        $this->required = false;
        $this->default = null;
        $this->flag = false;
    }

//    public static function required(string $name): self
//    {
//        return (new static($name))->required();
//    }
//
//    public static function optional(string $name): self
//    {
//        return (new static($name));
//    }

    public function required(): self
    {
        if ($this->default !== null) {
            throw new \Exception($this->name . ' argument already has default value.'
                . ' Can\'t mark as required');
        }

        $this->required = true;
        return $this;
    }

    public function defaultValue($default): self
    {
        if ($this->required === true) {
            throw new \Exception($this->name . ' argument is marked as required.'
                . ' Can\'t have default value');
        }

        $this->default = $default;
        return $this;
    }

    public function asFlag(): self
    {
        $this->flag = true;
        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function isRequired(): bool
    {
        return $this->required;
    }

    public function hasDefaultValue(): bool
    {
        return isset($this->default);
    }

    public function getDefaultValue()
    {
        return $this->default;
    }

    public function isFlag(): bool
    {
        return $this->flag;
    }
}
