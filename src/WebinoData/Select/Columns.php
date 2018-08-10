<?php
/**
 * Webino (http://webino.sk)
 *
 * @link        https://github.com/webino/WebinoData for the canonical source repository
 * @copyright   Copyright (c) 2013-2017 Webino, s. r. o. (http://webino.sk)
 * @author      Peter Bačinský <peter@bacinsky.sk>
 * @license     BSD-3-Clause
 */

namespace WebinoData\Select;

use Zend\Db\Sql\Expression;
use Zend\Db\Sql\Select;

/**
 * Class Columns
 */
class Columns extends AbstractHelper
{
    use ExpressionTrait;

    /**
     * Set select columns
     *
     * @param array $columns
     * @return $this
     */
    public function setColumns(array $columns)
    {
        $sqlSelect  = $this->select->getSqlSelect();
        $sqlColumns = $sqlSelect->getRawState($sqlSelect::COLUMNS);

        // remove star from SQL select columns
        $starIndex = array_search($sqlSelect::SQL_STAR, $sqlColumns);
        if (false !== $starIndex) {
            unset($sqlColumns[$starIndex]);
        }

        $columns = array_merge($sqlColumns, $columns);
        $columns = $this->columnsHandleStar($columns);
        $columns = $this->columnsHandleId($columns);
        $columns = $this->columnsManipulate($columns);

        $event = $this->select->getEvent();
        $event->setParam('columns', $columns);

        $this->select->getStore()->getEventManager()
            ->trigger('data.select.columns', $event);

        $sqlSelect->columns($event->getParam('columns'), false);
        return $this;
    }

    /**
     * @param iterable $columns
     * @return $this
     */
    public function addColumns(iterable $columns)
    {
        $selectColumns = $this->select->getColumns();
        foreach ($columns as $key => $value) {
            $selectColumns[$key] = $value;
        }
        $this->setColumns($selectColumns);
        return $this;
    }

    /**
     * @param string $name
     * @param string|array $value
     * @return $this
     */
    public function addColumn($name, $value)
    {
        $columns = array_replace($this->select->getColumns(), [$name => $value]);
        $this->setColumns($columns);
        return $this;
    }

    /**
     * @param string $name
     * @return $this
     */
    public function removeColumn($name)
    {
        $columns = $this->select->getColumns();
        if (isset($columns[$name])) {
            unset($columns[$name]);
        }
        $this->setColumns($columns);
        return $this;
    }

    /**
     * @param array $columns
     * @return array
     */
    private function columnsHandleStar(array $columns)
    {
        $tableName     = $this->select->getStore()->getTableName();
        $serviceConfig = $this->select->getStore()->getConfig();
        $inputFilter   = $serviceConfig['input_filter'];

        // remove input filter type
        unset($inputFilter['type']);

        $inputColumns = [];
        foreach ($inputFilter as $input) {
            if ($input) {
                $inputColumns[$input['name']] = new Expression("`$tableName`.`$input[name]`");
            }
        }

        $merge = false;
        foreach ($columns as $index => $value) {
            if (Select::SQL_STAR === $value) {
                $merge or $merge = true;
                unset($columns[$index]);
            }
        }

        return $merge ? array_merge($inputColumns, $columns) : $columns;
    }

    /**
     * @param array $columns
     * @return array
     */
    private function columnsHandleId(array $columns)
    {
        $tableName = $this->select->getStore()->getTableName();

        // prefix id with table name
        $idIndex = false;
        foreach ($columns as $index => $value) {
            if ('id' === $value) {
                $idIndex = $index;
                break;
            }
        }

        if (false !== $idIndex) {
            $columns[$idIndex] = new Expression("`$tableName`.`id`");

            if (is_numeric($idIndex)) {
                // we need to change the index to a string
                // when we want to use an expression
                $keys = array_keys($columns);
                $keyIndex = array_search($idIndex, $keys);

                $keys[$keyIndex] = 'id';
                $columns = array_combine($keys, array_values($columns));
            }
        }

        return $columns;
    }

    /**
     * @param array $columns
     * @return array
     */
    private function columnsManipulate(array $columns)
    {
        // manipulate columns
        foreach ($columns as $key => &$column) {

            // fix an array column to be string-able
            if (is_array($column)) {
                $column = new ArrayColumn($column);
                continue;
            }

            // store sub-selects
            if ($column instanceof $this->select) {
                $this->select->setSubSelect($key, $column);
                continue;
            }

            // use auto expression?
            is_string($column) and $column = $this->handleExpression($column);
        }

        return $columns;
    }
}
