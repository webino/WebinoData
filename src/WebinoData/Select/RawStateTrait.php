<?php

namespace WebinoData\Select;

use Zend\Db\Sql\Select;

/**
 * Class RawStateTrait
 */
trait RawStateTrait
{
    /**
     * @return Select
     */
    abstract public function getSqlSelect();

    /**
     * @return array
     */
    public function getColumns()
    {
        return $this->getSqlSelect()->getRawState('columns');
    }

    /**
     * @return array
     */
    public function getJoins()
    {
        return $this->getSqlSelect()->getRawState('joins');
    }

    /**
     * @return array
     */
    public function getWhere()
    {
        return $this->getSqlSelect()->getRawState('where');
    }

    /**
     * @return array
     */
    public function getHaving()
    {
        return $this->getSqlSelect()->getRawState('having');
    }

    /**
     * @return array
     */
    public function getGroup()
    {
        return $this->getSqlSelect()->getRawState('group');
    }

    /**
     * @return array
     */
    public function getOrder()
    {
        return $this->getSqlSelect()->getRawState('order');
    }

    /**
     * @return array
     */
    public function getLimit()
    {
        return $this->getSqlSelect()->getRawState('limit');
    }
}
