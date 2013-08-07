<?php

namespace WebinoData\Paginator\Adapter;

use WebinoData\DataSelect;
use Zend\Db\Sql\Expression;
use Zend\Db\Sql\Select;
use Zend\Paginator\Adapter\DbSelect;

class WebinoDataSelect extends DbSelect
{
    protected $dataSelect;
    protected $service;
    protected $overflow = 0;

    public function __construct(DataSelect $select, $service)
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

        $select = clone $this->select;
        $select->reset(Select::COLUMNS);
        $select->reset(Select::LIMIT);
        $select->reset(Select::OFFSET);
        $select->reset(Select::ORDER);

        // get join information, clear, and repopulate without columns
        $joins = $select->getRawState(Select::JOINS);
        $select->reset(Select::JOINS);
        foreach ($joins as $join) {
            $select->join($join['name'], $join['on'], array(), $join['type']);
        }

        $select->columns(array('c' => new Expression('COUNT(*)')));

        $sql       = $this->sql->getSqlStringForSqlObject($select);
        $statement = $this->sql->getAdapter()->createStatement($sql);
        $result    = $statement->execute();
        $row       = $result->current();

        $this->rowCount = $row['c'];

        return $this->rowCount;
    }
}
