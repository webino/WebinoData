<?php

namespace WebinoData\Paginator\Adapter;

use WebinoData\DataSelect;
use Zend\Cache\Storage\StorageInterface as CacheInterface;
use Zend\Db\Sql\Expression;
use Zend\Db\Sql\Select;
use Zend\Paginator\Adapter\DbSelect;

class AbstractWebinoDataSelect extends DbSelect
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
        
        $select->columns(array('c' => new Expression('COUNT(*)')));

        $sql       = $this->sql->getSqlStringForSqlObject($select);
        $statement = $this->sql->getAdapter()->createStatement($sql);

        try {
            $result = $statement->execute();
        } catch (\Exception $exc) {
            throw new \RuntimeException('Could not execute SQL ' . $sql, $exc->getCode(), $exc);
        }

        $row            = $result->current();
        $resultCount    = $result->count();
        $this->rowCount = 1 < $resultCount ? $resultCount : $row['c'];

        return $this->rowCount;
    }
}
