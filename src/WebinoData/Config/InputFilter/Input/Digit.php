<?php
/**
 * Webino (http://webino.sk)
 *
 * @link        https://github.com/webino/WebinoData for the canonical source repository
 * @copyright   Copyright (c) 2012-2016 Webino, s. r. o. (http://webino.sk)
 * @author      Peter Bačinský <peter@bacinsky.sk>
 * @license     BSD-3-Clause
 */

namespace WebinoData\Config\InputFilter\Input;

/**
 * Digit data type
 */
class Digit extends AbstractInput
{
    use RequirableTrait;
    use DefaultableTrait;

    /**
     * {@inheritDoc}
     */
    protected $spec = [
        'validators' => [
            'digits' => ['name' => 'Digits'],
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
     * @param int $min
     * @param int $max
     * @return $this
     */
    public function setBetween($min, $max)
    {
        $this->spec['validators'] = [
            'between' => [
                'name'    => 'Between',
                'options' => ['min' => $min, 'max' => $max],
            ],
        ];

        return $this;
    }
}
