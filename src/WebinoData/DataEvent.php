<?php
/**
 * Webino (http://webino.sk)
 *
 * @link        https://github.com/webino/WebinoData for the canonical source repository
 * @copyright   Copyright (c) 2013 Webino, s. r. o. (http://webino.sk)
 * @author      Peter Bačinský <peter@bacinsky.sk>
 * @license     New BSD License
 */

namespace WebinoData;

use ArrayAccess;
use Zend\EventManager\Event;

/**
 *
 */
class DataEvent extends Event
{
    /**#@+
     * Ajax events
     */
    const EVENT_SELECT = 'data.select';
    const EVENT_DELETE = 'data.delete';
    const EVENT_EXCHANGE_INVALID = 'data.exchange.invalid';
    const EVENT_EXCHANGE_PRE = 'data.exchange.pre';
    const EVENT_EXCHANGE_POST = 'data.exchange.post';
    const EVENT_FETCH_PRE = 'data.fetch.pre';
    const EVENT_FETCH_POST = 'data.fetch.post';
    const EVENT_EXPORT = 'data.export';
    const EVENT_IMPORT = 'data.import';
    /**#@-*/

    protected $service;
    protected $select;
    protected $data;
    protected $validData;
    protected $result;
    protected $rows;
    protected $row;
    protected $update;
    protected $arguments = array();

    /**
     * @return DataService
     */
    public function getService()
    {
        return $this->service;
    }

    public function setService(DataService $service)
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

    public function setSelect(DataSelect $select)
    {
        $this->select = $select;
        return $this;
    }

    /**
     * @return ArrayAccess
     */
    public function getData()
    {
        return $this->data;
    }

    public function setData(ArrayAccess $data)
    {
        $this->data = $data;
        return $this;
    }

    /**
     * @return ArrayAccess
     */
    public function getValidData()
    {
        return $this->validData;
    }

    public function setValidData(ArrayAccess $validData)
    {
        $this->validData = $validData;
        return $this;
    }

    public function getResult()
    {
        return $this->result;
    }

    public function setResult($result)
    {
        $this->result = $result;
        return $this;
    }

    /**
     * @return ArrayAccess
     */
    public function getRows()
    {
        return $this->rows;
    }

    public function setRows(ArrayAccess $rows)
    {
        $this->rows = $rows;
        return $this;
    }

    public function getRow()
    {
        return $this->row;
    }

    public function setRow(ArrayAccess $row)
    {
        $this->row = $row;
        return $this;
    }

    public function isUpdate()
    {
        return $this->update;
    }

    public function setUpdate($bool = true)
    {
        $this->update = (bool) $bool;
        return $this;
    }

    public function getArguments()
    {
        return $this->arguments;
    }

    public function setArguments(array $arguments)
    {
        $this->arguments = $arguments;
        return $this;
    }
}
