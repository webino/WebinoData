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
 * Visible data type
 */
class Visible extends Toggle
{
    /**
     * Frozen column name
     */
    public function __construct()
    {
        parent::__construct('visible');
        $this->setDefault(1);
    }
}
