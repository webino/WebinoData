<?php
/**
 * Webino (http://webino.sk)
 *
 * @link        https://github.com/webino/WebinoData for the canonical source repository
 * @copyright   Copyright (c) 2013-2017 Webino, s. r. o. (http://webino.sk)
 * @author      Peter Bačinský <peter@bacinsky.sk>
 * @license     BSD-3-Clause
 */

namespace WebinoData\Store;

use ArrayObject;
use WebinoData\Select;
use Zend\InputFilter\BaseInputFilter;

/**
 * Interface StoreInterface
 */
interface StoreInterface
{
    /**
     * Returns store configuration
     *
     * @return array
     */
    public function getConfig();

    /**
     * Returns valid input names
     *
     * @return array
     */
    public function getInputs();

    /**
     * Returns latest valid data
     *
     * @return array
     */
    public function getValidValues();

    /**
     * Returns last inserted primary key
     *
     * @return int
     */
    public function getLastInsertValue();

    /**
     * Returns input filter
     *
     * @return \Zend\InputFilter\InputFilterInterface|\WebinoData\InputFilter\InputFilter
     */
    public function getInputFilter();

    /**
     * Returns latest validation messages
     *
     * @return array|\string[]
     */
    public function getInputMessages();

    /**
     * Returns table name
     *
     * @return string
     */
    public function getTableName();

    /**
     * Returns database adapter
     *
     * @return \Zend\Db\Adapter\Adapter|\Zend\Db\Adapter\AdapterInterface
     */
    public function getAdapter();

    /**
     * Returns database SQL object
     *
     * @return \Zend\Db\Sql\Sql
     */
    public function getSql();

    /**
     * @return \Zend\Db\Adapter\Platform\PlatformInterface
     */
    public function getPlatform();

    /**
     * Returns data event
     *
     * @return \WebinoData\Event\DataEvent
     */
    public function getEvent();

    /**
     * @return \Zend\EventManager\EventManagerInterface
     */
    public function getEventManager();

    /**
     * Returns store plugin
     *
     * @param string|null $name
     * @return object
     */
    public function getPlugin($name = null);

    /**
     * Returns store data select
     *
     * @param array $columns
     * @return Select
     */
    public function select($columns = []);

    /**
     * Configures multiple selects
     *
     * @param array ...$selectNames
     * @return Select
     */
    public function configSelect(...$selectNames);

    /**
     * Configures select set
     *
     * @param string $name
     * @return Select
     */
    public function configSelects($name);

    /**
     * Select & fetch combo
     *
     * @param string $selectName
     * @param array $params
     * @return array|ArrayObject
     */
    public function fetch($selectName, $params = []);

    /**
     * Returns selected data
     *
     * @param Select $select
     * @param array $params
     * @return ArrayObject
     */
    public function fetchWith(Select $select, $params = []);

    /**
     * Returns selected data pairs
     *
     * @param Select $select
     * @param array $params
     * @return array
     */
    public function fetchPairs(Select $select, $params = []);

    /**
     * Run raw SQL
     *
     * @param string $query
     * @param null|array|\Zend\Db\Adapter\ParameterContainer $params
     * @return \Zend\Db\Adapter\Driver\ResultInterface
     */
    public function executeQuery($query, $params = null);

    /**
     * Toggle value
     *
     * @param string $column
     * @param mixed $where
     * @return mixed
     */
    public function toggle($column, $where);

    /**
     * Increment value
     *
     * @param string|array $column
     * @param mixed $where
     * @return mixed
     */
    public function increment($column, $where);

    /**
     * Decrement value
     *
     * @param string|array $column
     * @param mixed $where
     * @return mixed
     */
    public function decrement($column, $where);

    /**
     * Filter inputs by data
     *
     * @param array $data
     * @param BaseInputFilter $inputFilter
     * @return $this
     */
    public function filterInputFilter(array $data, BaseInputFilter $inputFilter);

    /**
     * Merges other input filter
     *
     * @param BaseInputFilter $inputFilter
     * @return $this
     */
    public function mergeInputFilter(BaseInputFilter $inputFilter);

    /**
     * Stores data
     *
     * @param array $array
     * @return int Affected rows
     */
    public function exchangeArray(array $array);

    /**
     * Imports data
     *
     * @param array $data
     * @return $this
     */
    public function import(array $data);

    /**
     * Exports data
     *
     * @param callable $callback
     * @param Select|null $select
     * @return $this
     */
    public function export(callable $callback, Select $select = null);

    /**
     * Returns true when 1:1 sub-store exists
     *
     * @param string $name
     * @return bool
     */
    public function hasOne($name);

    /**
     * Returns one or list of 1:1 sub-stores
     *
     * @param string|null $name
     * @return $this|array
     */
    public function one($name = null);

    /**
     * Returns true when n:m sub-store exists
     *
     * @param string $name
     * @return bool
     */
    public function hasMany($name);

    /**
     * Returns one or list of n:m sub-stores
     *
     * @param string|null $name
     * @return $this|array
     */
    public function many($name = null);

    /**
     * Returns 1:1 sub-store options
     *
     * @param string $name
     * @return array
     */
    public function oneSpec($name);

    /**
     * Returns n:m sub-store options
     *
     * @param string $name
     * @return array
     */
    public function manySpec($name);
}
