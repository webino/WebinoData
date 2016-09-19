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
 * Enabled data type
 */
class Enabled extends Toggle
{
    /**
     * Frozen column name
     */
    public function __construct()
    {
        parent::__construct('enabled');
        $this->setDefault(1);
    }
}
