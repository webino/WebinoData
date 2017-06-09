<?php

namespace WebinoData\Select;

use WebinoData\DataSelect;

/**
 * Class AbstractHelper
 */
abstract class AbstractHelper
{
    /**
     * @var DataSelect
     */
    protected $select;

    /**
     * @param DataSelect $select
     */
    public function __construct(DataSelect $select)
    {
        $this->setSelect($select);
    }

    /**
     * @param DataSelect $select
     * @return $this
     */
    public function setSelect(DataSelect $select)
    {
        $this->select = $select;
        return $this;
    }
}
