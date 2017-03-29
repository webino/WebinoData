<?php
/**
 * Webino (http://webino.sk)
 *
 * @link        https://github.com/webino/WebinoData for the canonical source repository
 * @copyright   Copyright (c) 2017 Webino, s. r. o. (http://webino.sk)
 * @author      Peter Bačinský <peter@bacinsky.sk>
 * @license     BSD-3-Clause
 */

namespace WebinoData\Config\InputFilter\Input;

/**
 * Flag data type
 */
class Flag extends AbstractInput
{
    use DefaultableTrait;

    /**
     * {@inheritDoc}
     */
    protected $spec = [
        'switch'     => true,
        'required'   => true,
        'validators' => ['digits' => ['name' => 'Digits']],
    ];

    /**
     * @param string $name
     */
    public function __construct($name)
    {
        $this->setName($name);
        $this->setDefault(0);
    }
}
