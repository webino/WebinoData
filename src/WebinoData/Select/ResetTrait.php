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
     * @param string $part
     * @return $this
     */
    public function reset($part)
    {
        $this->getSqlSelect()->reset($part);
        return $this;
    }

    /**
     * @return $this
     */
    public function resetColumns()
    {
        $this->reset(Select::COLUMNS);
        return $this;
    }

    /**
     * @return $this
     */
    public function resetJoins()
    {
        $this->reset(Select::JOINS);
        return $this;
    }

    /**
     * @return $this
     */
    public function resetWhere()
    {
        $this->reset(Select::WHERE);
        return $this;
    }

    /**
     * @return $this
     */
    public function resetGroup()
    {
        $this->reset(Select::GROUP);
        return $this;
    }

    /**
     * @return $this
     */
    public function resetHaving()
    {
        $this->reset(Select::HAVING);
        return $this;
    }

    /**
     * @return $this
     */
    public function resetLimit()
    {
        $this->reset(Select::LIMIT);
        return $this;
    }

    /**
     * @return $this
     */
    public function resetOffset()
    {
        $this->reset(Select::OFFSET);
        return $this;
    }

    /**
     * @return $this
     */
    public function resetOrder()
    {
        $this->reset(Select::ORDER);
        return $this;
    }

    /**
     * @return $this
     */
    public function resetCombine()
    {
        $this->reset(Select::COMBINE);
        return $this;
    }
}
