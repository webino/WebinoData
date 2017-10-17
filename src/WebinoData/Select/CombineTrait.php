<?php

namespace WebinoData\Select;

use WebinoData\DataSelect;
use Zend\Db\Sql\Select;

/**
 * Class CombineTrait
 */
trait CombineTrait
{
    /**
     * @return Select
     */
    abstract public function getSqlSelect();

    /**
     * Combine select
     *
     * @see CombineTrait::union() Union select
     *
     * @param DataSelect $select
     * @param string $type
     * @param string $modifier
     * @return $this
     */
    public function combine(DataSelect $select, $type = Select::COMBINE_UNION, $modifier = '')
    {
        $this->getSqlSelect()->combine($select->getSqlSelect(), $type, $modifier);
        return $this;
    }

    /**
     * Union select
     *
     * @param DataSelect $select
     * @return $this
     */
    public function union(DataSelect $select)
    {
        $this->combine($select, Select::COMBINE_UNION, '');
        return $this;
    }
}
