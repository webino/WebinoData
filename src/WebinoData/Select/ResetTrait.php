<?php

namespace WebinoData\Select;

use Zend\Db\Sql\Select;

/**
 * Class ResetTrait
 */
trait ResetTrait
{
    /**
     * @return Select
     */
    abstract public function getSqlSelect();

    /**
     * @return $this
     */
    public function resetColumns()
    {
        $this->getSqlSelect()->reset(Select::COLUMNS);
        return $this;
    }

    /**
     * @return $this
     */
    public function resetJoins()
    {
        $this->getSqlSelect()->reset(Select::JOINS);
        return $this;
    }

    /**
     * @return $this
     */
    public function resetWhere()
    {
        $this->getSqlSelect()->reset(Select::WHERE);
        return $this;
    }

    /**
     * @return $this
     */
    public function resetGroup()
    {
        $this->getSqlSelect()->reset(Select::GROUP);
        return $this;
    }

    /**
     * @return $this
     */
    public function resetHaving()
    {
        $this->getSqlSelect()->reset(Select::HAVING);
        return $this;
    }

    /**
     * @return $this
     */
    public function resetLimit()
    {
        $this->getSqlSelect()->reset(Select::LIMIT);
        return $this;
    }

    /**
     * @return $this
     */
    public function resetOffset()
    {
        $this->getSqlSelect()->reset(Select::OFFSET);
        return $this;
    }

    /**
     * @return $this
     */
    public function resetOrder()
    {
        $this->getSqlSelect()->reset(Select::ORDER);
        return $this;
    }

    /**
     * @return $this
     */
    public function resetCombine()
    {
        $this->getSqlSelect()->reset(Select::COMBINE);
        return $this;
    }
}
