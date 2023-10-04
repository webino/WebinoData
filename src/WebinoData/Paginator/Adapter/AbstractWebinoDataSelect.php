<?php

namespace WebinoData\Paginator\Adapter;

use WebinoData\DataSelect;
use WebinoData\DataService;
use Zend\Db\Sql\Expression;
use Zend\Paginator\Adapter\DbSelect;

/**
 * Class AbstractWebinoDataSelect
 */
class AbstractWebinoDataSelect extends DbSelect
{
    /**
     * @var DataSelect
     */
    protected $dataSelect;

    /**
     * @var DataService
     */
    protected $service;

    /**
     * @var int
     */
    protected $overflow = 0;

    /**
     * @param DataSelect $select
     * @param DataService $service
     */
    public function __construct(DataSelect $select, DataService $service)
    {
        parent::__construct($select->getSqlSelect(), $service->getAdapter());

        $this->dataSelect = $select;
        $this->service    = $service;
    }

    /**
     * @param int $overflow
     * @return $this
     */
    public function setOverflow($overflow)
    {
        $this->overflow = (int) $overflow;
        return $this;
    }

    /**
     * Returns an array of items for a page.
     *
     * @param int $offset Page offset
     * @param int $itemCountPerPage Number of items per page
     * @return array
     */
    public function getItems($offset, $itemCountPerPage)
    {
        $select = clone $this->dataSelect;
        $select->offset($offset);
        $select->limit($itemCountPerPage + $this->overflow);
        $this->dataSelect->setHash($select->getHash());
        return $this->service->fetchWith($select);
    }

    /**
     * Returns the total number of rows in the result set
     *
     * @return int
     */
    public function count()
    {
        if ($this->rowCount !== null) {
            return $this->rowCount;
        }

        $select = clone $this->dataSelect;
        $this->rowCount = $select->count();
        return $this->rowCount;
    }
}
