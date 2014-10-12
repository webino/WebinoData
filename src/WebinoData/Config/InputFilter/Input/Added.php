<?php
/**
 * Webino (http://webino.sk)
 *
 * @link        https://github.com/webino/WebinoData for the canonical source repository
 * @copyright   Copyright (c) 2012-2014 Webino, s. r. o. (http://webino.sk)
 * @author      Peter Bačinský <peter@bacinsky.sk>
 * @license     BSD-3-Clause
 */

namespace WebinoData\Config\Input;

/**
 * Added datetime data type
 */
class Added extends DateTime
{
    /**
     * Frozen column name
     */
    public function __construct()
    {
        parent::__construct('added');
    }
}
