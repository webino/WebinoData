<?php
/**
 * Webino (http://webino.sk)
 *
 * @link        https://github.com/webino/WebinoData for the canonical source repository
 * @copyright   Copyright (c) 2012-2014 Webino, s. r. o. (http://webino.sk)
 * @author      Peter Bačinský <peter@bacinsky.sk>
 * @license     BSD-3-Clause
 */

namespace WebinoData\Config\InputFilter\Input;

/**
 * Order data type
 */
class Order extends AbstractInput
{
    /**
     * {@inheritDoc}
     */
    protected $spec = [
        'name'       => 'order',
        'required'   => false,
        'validators' => ['digits' => ['name' => 'Digits']],
    ];
}
