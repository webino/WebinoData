<?php

namespace WebinoData\Select;

use Zend\Db\Sql\Select;

/**
 * Class LimitTrait
 */
trait LimitTrait
{
    /**
     * @return Select
     */
    abstract public function getSqlSelect();

    /**
     * @param string $limit
     * @return $this
     */
    public function limit($limit)
    {
        $this->getSqlSelect()->limit((int) $limit);
        return $this;
    }

    /**
     * @param int $offset
     * @return $this
     */
    public function offset($offset)
    {
        $this->getSqlSelect()->offset((int) $offset);
        return $this;
    }
}
