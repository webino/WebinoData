<?php
/**
 * Webino (http://webino.sk)
 *
 * @link        https://github.com/webino/WebinoData for the canonical source repository
 * @copyright   Copyright (c) 2012-2015 Webino, s. r. o. (http://webino.sk)
 * @author      Peter Bačinský <peter@bacinsky.sk>
 * @license     BSD-3-Clause
 */

namespace WebinoData\Config\InputFilter\Input;

use WebinoData\Filter\ToFloat;

/**
 * Class Decimal
 */
class Decimal extends AbstractInput
{
    use RequirableTrait;
    use DefaultableTrait;

    /**
     * {@inheritDoc}
     */
    protected $spec = [
        'filters' => [
            'to-float' => ['name' => ToFloat::class],
        ],
    ];

    /**
     * @param string $name
     */
    public function __construct($name)
    {
        $this->setName($name);
    }
}
