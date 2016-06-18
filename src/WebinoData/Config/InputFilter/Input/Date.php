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
 * Date data type
 */
class Date extends AbstractInput
{
    /**
     * {@inheritDoc}
     */
    protected $spec = [
        'required' => false,
        'filters' => [
            'date' => ['name' => 'DateTimeFormatter'],
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
