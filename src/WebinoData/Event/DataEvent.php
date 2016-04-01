<?php
/**
 * Webino (http://webino.sk)
 *
 * @link        https://github.com/webino/WebinoData for the canonical source repository
 * @copyright   Copyright (c) 2013-2016 Webino, s. r. o. (http://webino.sk)
 * @author      Peter Bačinský <peter@bacinsky.sk>
 * @license     New BSD License
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
    protected $service;

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
     * @var array
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
     * @return DataService
     */
    public function getService()
    {
        return $this->service;
    }

    /**
     * @param AbstractDataService $service
     * @return $this
     */
    public function setService(AbstractDataService $service)
    {
        $this->service = $service;
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
     * @return array
     */
    public function getResult()
    {
        return $this->result;
    }

    /**
     * @param array $result
     * @return $this
     */
    public function setResult(array $result)
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
}
