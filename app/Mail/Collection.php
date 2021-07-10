<?php

namespace App\Mail;

class Collection extends \ArrayObject
{
    private string $type;

    public function __construct(string $type, array $data = [])
    {
        $this->type = $type;
        parent::__construct($data);
    }

    public function current()
    {
        return current($this->data);
    }

    public function next()
    {
        return next($this->data);
    }

    public function reset(): void
    {
        reset($this->data);
    }

    public function offsetSet($key, $value)
    {
        if (!$this->checkType($value)) {
            throw new \InvalidArgumentException('Type error: '.$this->type);
        }

        parent::offsetSet($key, $value);
    }

    public function append($value)
    {
        if (!$this->checkType($value)) {
            throw new \InvalidArgumentException('Type error');
        }

        parent::append($value);
    }

    /**
     * Return true if the given value respect the $this->type.
     *
     * @param $value
     */
    protected function checkType($value): bool
    {
        switch ($this->type) {
            case 'int':
                return is_int($value);
            case 'string':
                return is_string($value);
            case 'float':
                return is_float($value);
            case 'array':
                return is_array($value);
            default:
                return $value instanceof $this->type;
        }
    }
}
