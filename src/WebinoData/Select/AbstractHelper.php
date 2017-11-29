<?php
/**
 * Webino (http://webino.sk)
 *
 * @link        https://github.com/webino/WebinoData for the canonical source repository
 * @copyright   Copyright (c) 2013-2017 Webino, s. r. o. (http://webino.sk)
 * @author      Peter Bačinský <peter@bacinsky.sk>
 * @license     BSD-3-Clause
 */

namespace WebinoData\Select;

use WebinoData\Select;

/**
 * Class AbstractHelper
 */
abstract class AbstractHelper
{
    /**
     * @var Select
     */
    protected $select;

    /**
     * @param Select|object $select
     */
    public function __construct(Select $select)
    {
        $this->setSelect($select);
    }

    /**
     * @param Select $select
     * @return $this
     */
    public function setSelect(Select $select)
    {
        $this->select = $select;
        return $this;
    }
}
