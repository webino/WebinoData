<?php

namespace WebinoData\Paginator\Adapter;

use WebinoData\DataSelect as Select;

class WebinoDataSelect extends \Zend\Paginator\Adapter\DbSelect
{
    protected $dataSelect;
    protected $service;
    protected $overflow = 0;

    public function __construct(Select $select, $service)
    {
        parent::__construct($select->getSqlSelect(), $service->getAdapter());

        $this->dataSelect = $select;
        $this->service    = $service;
    }

    public function setOverflow($overflow)
    {
        $this->overflow = $overflow;
        return $this;
    }

    /**
     * Returns an array of items for a page.
     *
     * @param  int $offset           Page offset
     * @param  int $itemCountPerPage Number of items per page
     * @return array
     */
    public function getItems($offset, $itemCountPerPage)
    {
        $select = clone $this->dataSelect;
        $select->offset($offset);
        $select->limit($itemCountPerPage + $this->overflow);

        return $this->service->fetchWith($select);
    }
}
