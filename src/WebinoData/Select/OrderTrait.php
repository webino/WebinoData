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

use Zend\Db\Sql\Select;

/**
 * Trait OrderTrait
 */
trait OrderTrait
{
    /**
     * @var Order
     */
    protected $orderHelper;

    /**
     * @return Select
     */
    abstract public function getSqlSelect();

    /**
     * @return Order
     */
    public function getOrderHelper()
    {
        if (null === $this->orderHelper) {
            $this->orderHelper = new Order($this);
        }
        return $this->orderHelper;
    }

    /**
     * @param Order $orderHelper
     * @return $this
     */
    public function setOrderHelper(Order $orderHelper)
    {
        $this->orderHelper = $orderHelper;
        return $this;
    }

    /**
     * @param string|array $order
     * @return $this
     */
    public function order($order)
    {
        $this->getOrderHelper()->order($order);
        return $this;
    }
}
