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
 * InArray data type
 */
class InArray extends AbstractInput
{
    use DefaultableTrait;

    /**
     * {@inheritDoc}
     */
    protected $spec = [
        'validators' => [
            'inArray' => ['name' => 'InArray'],
        ],
    ];

    /**
     * @param string $name
     */
    public function __construct($name)
    {
        $this->setName($name);
    }

    /**
     * @param array $haystack
     * @return $this
     */
    public function setHaystack(array $haystack)
    {
        $this->spec['validators']['inArray']['options']['haystack'] = $haystack;
        return $this;
    }
}
