<?php
/**
 * Webino (http://webino.sk)
 *
 * @link        https://github.com/webino/WebinoData for the canonical source repository
 * @copyright   Copyright (c) 2013-2017 Webino, s. r. o. (http://webino.sk)
 * @author      Peter Bačinský <peter@bacinsky.sk>
 * @license     BSD-3-Clause
 */

namespace WebinoData;

use Zend\Paginator\Paginator as BasePaginator;

/**
 * Class Paginator
 */
class Paginator extends BasePaginator
{
    /**
     * @return \WebinoData\Paginator\PaginatorSelect
     */
    public function getSelect()
    {
        return $this->adapter;
    }
}
