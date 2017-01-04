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
 * Class Email
 */
class Email extends Common
{
    /**
     * {@inheritDoc}
     */
    protected $spec = [
        'required' => false,
        'validators' => [
            'length' => [
                'name'    => 'StringLength',
                'options' => ['min' => 6, 'max' => 100],
            ],
            'email' => ['name' => 'EmailAddress'],
        ],
        'filters' => [
            'trim' => ['name' => 'StringTrim'],
        ],
    ];
}
