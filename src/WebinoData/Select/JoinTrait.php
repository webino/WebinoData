<?php

namespace WebinoData\Select;

use Zend\Db\Sql\Select;

/**
 * Trait JoinTrait
 */
trait JoinTrait
{
    /**
     * @var Join
     */
    protected $joinHelper;

    /**
     * @return Select
     */
    abstract public function getSqlSelect();

    /**
     * @return Join
     */
    public function getJoinHelper()
    {
        if (null === $this->joinHelper) {
            $this->joinHelper = new Join($this);
        }
        return $this->joinHelper;
    }

    /**
     * @param Join $joinHelper
     * @return $this
     */
    public function setJoinHelper(Join $joinHelper)
    {
        $this->joinHelper = $joinHelper;
        return $this;
    }

    /**
     * @param string|array $name
     * @param string $on
     * @param string|array $columns
     * @param string $type
     * @return $this
     */
    public function join($name, $on, $columns = Select::SQL_STAR, $type = Select::JOIN_INNER)
    {
        $this->getJoinHelper()->join($name, $on, $columns, $type);
        return $this;
    }

    /**
     * @param string|array $name
     * @param string $on
     * @param string|array $columns
     * @return $this
     */
    public function joinLeft($name, $on, $columns = Select::SQL_STAR)
    {
        $this->join($name, $on, $columns, Select::JOIN_LEFT);
        return $this;
    }

    /**
     * @param string|array $name
     * @param string $on
     * @param string|array $columns
     * @return $this
     */
    public function joinRight($name, $on, $columns = Select::SQL_STAR)
    {
        $this->join($name, $on, $columns, Select::JOIN_RIGHT);
        return $this;
    }

    /**
     * @param string|array $name
     * @param string $on
     * @param string|array $columns
     * @return $this
     */
    public function joinInner($name, $on, $columns = Select::SQL_STAR)
    {
        $this->join($name, $on, $columns, Select::JOIN_INNER);
        return $this;
    }
}
