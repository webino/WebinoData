<?php
/**
 * Webino (http://webino.sk)
 *
 * @link        https://github.com/webino/WebinoData for the canonical source repository
 * @copyright   Copyright (c) 2016 Webino, s. r. o. (http://webino.sk)
 * @author      Peter Bačinský <peter@bacinsky.sk>
 * @license     BSD-3-Clause
 */

namespace WebinoData\Config\InputFilter\Input;

/**
 * Class Common
 */
class Common extends AbstractInput
{
    use DefaultableTrait;
    use RequirableTrait;

    /**
     * {@inheritDoc}
     */
    protected $spec = [
        'required' => false,
    ];

    /**
     * @param string $name
     */
    public function __construct($name)
    {
        $this->setName($name);
    }

    /**
     * @param int $min
     * @return self
     */
    public function setMin($min)
    {
        $this->spec['validators']['length']['options']['min'] = (int) $min;
        return $this;
    }

    /**
     * @param int $max
     * @return self
     */
    public function setMax($max)
    {
        $this->spec['validators']['length']['options']['max'] = (int) $max;
        return $this;
    }
}
