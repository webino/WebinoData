<?php
/**
 * Webino (http://webino.sk)
 *
 * @link        https://github.com/webino/WebinoData for the canonical source repository
 * @copyright   Copyright (c) 2013-2017 Webino, s. r. o. (http://webino.sk)
 * @author      Peter Bačinský <peter@bacinsky.sk>
 * @license     BSD-3-Clause
 */

namespace WebinoData\Event;

use ArrayObject;
use WebinoData\AbstractDataService;
use WebinoData\DataSelect;
use WebinoData\DataService;

/**
 * Class DataEvent
 * @TODO extends \Zend\EventManager\Event
 */
class DataEvent extends \WebinoData\DataEvent implements DataEventInterface
{
    /**
     * @var AbstractDataService
     */
    protected $store;

    /**
     * @var DataSelect
     */
    protected $select;

    /**
     * @var ArrayObject
     */
    protected $data;

    /**
     * @var ArrayObject
     */
    protected $validData;

    /**
     * @var mixed
     */
    protected $result;

    /**
     * @var ArrayObject
     */
    protected $rows;

    /**
     * @var ArrayObject
     */
    protected $row;

    /**
     * @var int
     */
    protected $affectedRows;

    /**
     * @var bool
     */
    protected $update;

    /**
     * @var array
     */
    protected $arguments = [];

    /**
     * @var mixed
     */
    protected $wherePredicate;

    /**
     * @var string
     */
    protected $whereCombination;

    /**
     * @var string
     */
    protected $joinOn;

    /**
     * @var string|array
     */
    protected $joinColumns = [];

    /**
     * @return DataService
     */
    public function getStore()
    {
        return $this->store;
    }

    /**
     * @return DataService
     * @deprecated use getStore()
     */
    public function getService()
    {
        return $this->store;
    }

    /**
     * @param AbstractDataService $store
     * @return $this
     */
    public function setStore(AbstractDataService $store)
    {
        $this->store = $store;
        return $this;
    }

    /**
     * @param AbstractDataService $store
     * @return $this
     * @deprecated use setStore()
     */
    public function setService(AbstractDataService $store)
    {
        $this->store = $store;
        return $this;
    }

    /**
     * @return DataSelect
     */
    public function getSelect()
    {
        return $this->select;
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

    /**
     * @return ArrayObject
     */
    public function getData()
    {
        if (null === $this->data) {
            $this->data = new ArrayObject;
        }
        return $this->data;
    }

    /**
     * @param ArrayObject $data
     * @return $this
     */
    public function setData(ArrayObject $data)
    {
        $this->data = $data;
        return $this;
    }

    /**
     * @return ArrayObject
     */
    public function getValidData()
    {
        if (null === $this->validData) {
            $this->validData = new ArrayObject;
        }
        return $this->validData;
    }

    /**
     * @param ArrayObject $validData
     * @return $this
     */
    public function setValidData(ArrayObject $validData)
    {
        $this->validData = $validData;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getResult()
    {
        return $this->result;
    }

    /**
     * @param mixed $result
     * @return $this
     */
    public function setResult($result)
    {
        $this->result = $result;
        return $this;
    }

    /**
     * @return ArrayObject
     */
    public function getRows()
    {
        return $this->rows;
    }

    /**
     * @param ArrayObject $rows
     * @return $this
     */
    public function setRows(ArrayObject $rows)
    {
        if (null === $this->rows) {
            $this->rows = new ArrayObject;
        }
        $this->rows = $rows;
        return $this;
    }

    /**
     * @return ArrayObject
     */
    public function getRow()
    {
        return $this->row;
    }

    /**
     * @param ArrayObject $row
     * @return $this
     */
    public function setRow(ArrayObject $row)
    {
        $this->row = $row;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getAffectedRows()
    {
        return $this->affectedRows;
    }

    /**
     * @param int $affectedRows
     * @return $this
     */
    public function setAffectedRows($affectedRows)
    {
        $this->affectedRows = (int) $affectedRows;
        return $this;
    }

    /**
     * @return bool
     */
    public function isUpdate()
    {
        return $this->update;
    }

    /**
     * @param bool|true $bool
     * @return $this
     */
    public function setUpdate($bool = true)
    {
        $this->update = (bool) $bool;
        return $this;
    }

    /**
     * @return array
     */
    public function getArguments()
    {
        return $this->arguments;
    }

    /**
     * @param array $arguments
     * @return $this
     */
    public function setArguments(array $arguments)
    {
        $this->arguments = $arguments;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getWherePredicate()
    {
        $this->wherePredicate = $this->getParam('predicate', $this->wherePredicate); // TODO remove, legacy
        return $this->wherePredicate;
    }

    /**
     * @param mixed $predicate
     * @return DataEvent
     */
    public function setWherePredicate($predicate)
    {
        $this->setParam('predicate', $predicate); // TODO remove, legacy
        $this->wherePredicate = $predicate;
        return $this;
    }

    /**
     * @return string
     */
    public function getWhereCombination()
    {
        $this->whereCombination = $this->getParam('combination', $this->whereCombination); // TODO remove, legacy
        return $this->whereCombination;
    }

    /**
     * @param string $combination
     * @return DataEvent
     */
    public function setWhereCombination($combination)
    {
        $this->setParam('combination', $combination); // TODO remove, legacy
        $this->whereCombination = (string) $combination;
        return $this;
    }

    /**
     * @return string
     */
    public function getJoinOn()
    {
        $this->joinOn = $this->getParam('on', $this->joinOn); // TODO remove, legacy
        return $this->joinOn;
    }

    /**
     * @param string $on
     * @return $this
     */
    public function setJoinOn($on)
    {
        $this->setParam('on', $on); // TODO remove, legacy
        $this->joinOn = $on;
        return $this;
    }

    /**
     * @return string|array
     */
    public function getJoinColumns()
    {
        return $this->joinColumns;
    }

    /**
     * @param string|array $columns
     * @return DataEvent
     */
    public function setJoinColumns($columns)
    {
        $this->joinColumns = $columns;
        return $this;
    }

    /**
     * @return void
     */
    public function __clone()
    {
        $this->select and $this->select = clone $this->select;
        $this->data and $this->data = clone $this->data;
        $this->validData and $this->validData = clone $this->validData;
        $this->rows and $this->rows = clone $this->rows;
        $this->row and $this->row = clone $this->row;

        $this->wherePredicate && is_object($this->wherePredicate)
            and $this->wherePredicate = clone $this->wherePredicate;
    }
}
