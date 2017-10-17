<?php

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
