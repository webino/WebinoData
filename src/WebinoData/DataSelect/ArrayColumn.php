<?php

namespace WebinoData\DataSelect;

class ArrayColumn extends \ArrayObject
{
    protected $pattern = 'WebinoData\DataSelect[%s]';

    public function getPattern()
    {
        return $this->pattern;
    }

    public function setPattern($pattern)
    {
        $this->pattern = $pattern;
        return $this;
    }

    public function __toString()
    {
        return sprintf($this->getPattern(), join(', ', $this->getArrayCopy()));
    }
}
