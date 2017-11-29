<?php
/**
 * Webino (http://webino.sk)
 *
 * @link        https://github.com/webino/WebinoData for the canonical source repository
 * @copyright   Copyright (c) 2013-2017 Webino, s. r. o. (http://webino.sk)
 * @author      Peter Bačinský <peter@bacinsky.sk>
 * @license     BSD-3-Clause
 */

namespace WebinoData\Select;

/**
 * Class ArrayColumn
 */
class ArrayColumn extends \ArrayObject
{
    /**
     * @var string
     */
    protected $pattern = 'WebinoData\Select[%s]';

    /**
     * Returns string representation pattern
     *
     * @return string
     */
    public function getPattern()
    {
        return $this->pattern;
    }

    /**
     * Set string representation pattern
     *
     * @param $pattern
     * @return $this
     */
    public function setPattern($pattern)
    {
        $this->pattern = $pattern;
        return $this;
    }

    /**
     * String representation
     *
     * @return string
     */
    public function __toString()
    {
        return sprintf($this->getPattern(), join(', ', $this->getArrayCopy()));
    }
}
