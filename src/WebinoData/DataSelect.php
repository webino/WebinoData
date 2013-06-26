<?php

namespace WebinoData;

use Zend\Db\Adapter\Platform\PlatformInterface;
use Zend\Db\Sql\Predicate\PredicateSet;
use Zend\Db\Sql\Select;

class DataSelect
{
    protected $service;
    protected $sqlSelect;
    protected $subselects = array();

    public function __construct(DataService $service, Select $select)
    {
        $this->service   = $service;
        $this->sqlSelect = $select;
    }

    public function getSqlSelect()
    {
        return $this->sqlSelect;
    }

    public function getColumns()
    {
        return $this->sqlSelect->getRawState('columns');
    }

    public function columns(array $columns, $prefixColumnsWithTable = true)
    {
        foreach ($columns as $key => &$column) {

            if ($column instanceof self) {
                $this->subselect($key, $column);
            }
        }

        $event = $this->service->getEvent();

        $event
            ->setSelect($this)
            ->setParam('columns', $columns);

        $this->service->getEventManager()
            ->trigger('data.select.columns', $event);

        $this->sqlSelect->columns($event->getParam('columns'), $prefixColumnsWithTable);
        return $this;
    }

    public function addColumn($name, $value)
    {
        $columns = array_replace(
            $this->getColumns(),
            array($name => $value)
        );
        $this->columns($columns);
        return $this;
    }

    public function limit($limit)
    {
        $this->sqlSelect->limit($limit);
        return $this;
    }

    public function join($name, $on, $columns = Select::SQL_STAR, $type = Select::JOIN_INNER)
    {
        $this->sqlSelect->join($name, $on, $columns, $type);
        return $this;
    }

    public function offset($offset)
    {
        $this->sqlSelect->offset($offset);
        return $this;
    }

    public function order($order)
    {
        $this->sqlSelect->order($order);
        return $this;
    }

    public function where($predicate, $combination = PredicateSet::OP_AND)
    {
        $this->sqlSelect->where($predicate, $combination);
        return $this;
    }

    public function subselect($name, DataSelect $select = null)
    {
        if (null === $select) {
            return $this->subselects[$name];
        }

        $this->subselects[$name] = $select;
        return $this;
    }

    public function search($term, array $columns = array(), $combination = PredicateSet::OP_AND)
    {
        if (empty($term)) {
            return $this;
        }

        if (is_array($term)) {
            foreach ($term as $subKey => $subTerm) {

                empty($subKey) || empty($subTerm) or
                    $this->search($subTerm, array($subKey));
            }
            return $this;
        }

        $term     = preg_replace('~[^a-zA-Z0-9]+~', ' ', $term);
        $platform = $this->service->getPlatform();
        $where    = array();

        foreach (explode(' ', $term) as $word) {

            if (empty($word)) {
                continue;
            }

            foreach ($columns as $col) {

                $word    = preg_replace('~[^a-zA-Z0-9]+~', '%', $word);
                $where[] = $platform->quoteIdentifier($col) . ' LIKE '
                         . $platform->quoteValue('%' . $word . '%');
            }
        }

        if (empty($where)) {
            return $this;
        }

        $this->sqlSelect->where('(' . join(' AND ', $where) . ')', $combination);
        return $this;
    }

    public function group($group)
    {
        $this->sqlSelect->group($group);
        return $this;
    }

    /**
     * Get SQL string for statement
     *
     * @param  null|PlatformInterface $adapterPlatform If null, defaults to Sql92
     * @return string
     */
    public function getSqlString(PlatformInterface $adapterPlatform = null)
    {
        return $this->sqlSelect->getSqlString($adapterPlatform);
    }

    /**
     * @param string $part
     * @return Select
     */
    public function reset($part)
    {
        return $this->sqlSelect->reset($part);
    }

    public function __toString()
    {
        return $this->getSqlString($this->service->getPlatform());
    }

    /**
     * TODO
     *
     * @param PlatformInterface $platform
     * @param DriverInterface $driver
     * @param ParameterContainer $parameterContainer
     * @return null|array
     */
    protected function processSelect(PlatformInterface $platform, DriverInterface $driver = null, ParameterContainer $parameterContainer = null)
    {
        $expr = 1;

        if (!$this->table) {
            return null;
        }

        $table = $this->table;
        $schema = $alias = null;

        if (is_array($table)) {
            $alias = key($this->table);
            $table = current($this->table);
        }

        // create quoted table name to use in columns processing
        if ($table instanceof TableIdentifier) {
            list($table, $schema) = $table->getTableAndSchema();
        }

        if ($table instanceof Select) {
            $table = '(' . $this->processSubselect($table, $platform, $driver, $parameterContainer) . ')';
        } else {
            $table = $platform->quoteIdentifier($table);
        }

        if ($schema) {
            $table = $platform->quoteIdentifier($schema) . $platform->getIdentifierSeparator() . $table;
        }

        if ($alias) {
            $fromTable = $platform->quoteIdentifier($alias);
            $table = $this->renderTable($table, $fromTable);
        } else {
            $fromTable = $table;
        }

        if ($this->prefixColumnsWithTable) {
            $fromTable .= $platform->getIdentifierSeparator();
        } else {
            $fromTable = '';
        }

        // process table columns
        $columns = array();
        foreach ($this->columns as $columnIndexOrAs => $column) {

            $columnName = '';
            if ($column === self::SQL_STAR) {
                // todo
                $columns[] = array($platform->getIdentifierSeparator() . self::SQL_STAR);
                continue;
            }

            if ($column instanceof Expression) {
                $columnParts = $this->processExpression(
                    $column,
                    $platform,
                    $driver,
                    $this->processInfo['paramPrefix'] . ((is_string($columnIndexOrAs)) ? $columnIndexOrAs : 'column')
                );
                if ($parameterContainer) {
                    $parameterContainer->merge($columnParts->getParameterContainer());
                }
                $columnName .= $columnParts->getSql();
            } else {
                $columnName .= $fromTable . $platform->quoteIdentifier($column);
            }

            // process As portion
            if (is_string($columnIndexOrAs)) {
                $columnAs = $platform->quoteIdentifier($columnIndexOrAs);
            } elseif (stripos($columnName, ' as ') === false) {
                $columnAs = (is_string($column)) ? $platform->quoteIdentifier($column) : 'Expression' . $expr++;
            }
            $columns[] = (isset($columnAs)) ? array($columnName, $columnAs) : array($columnName);
        }

        $separator = $platform->getIdentifierSeparator();

        // process join columns
        foreach ($this->joins as $join) {
            foreach ($join['columns'] as $jKey => $jColumn) {
                $jColumns = array();
                if ($jColumn instanceof ExpressionInterface) {
                    $jColumnParts = $this->processExpression(
                        $jColumn,
                        $platform,
                        $driver,
                        $this->processInfo['paramPrefix'] . ((is_string($jKey)) ? $jKey : 'column')
                    );
                    if ($parameterContainer) {
                        $parameterContainer->merge($jColumnParts->getParameterContainer());
                    }
                    $jColumns[] = $jColumnParts->getSql();
                } else {
                    $name = (is_array($join['name'])) ? key($join['name']) : $name = $join['name'];
                    if ($name instanceof TableIdentifier) {
                        $name = $platform->quoteIdentifier($name->getSchema()) . $separator . $platform->quoteIdentifier($name->getTable());
                    } else {
                        $name = $platform->quoteIdentifier($name);
                    }
                    $jColumns[] = $name . $separator . $platform->quoteIdentifierInFragment($jColumn);
                }
                if (is_string($jKey)) {
                    $jColumns[] = $platform->quoteIdentifier($jKey);
                } elseif ($jColumn !== self::SQL_STAR) {
                    $jColumns[] = $platform->quoteIdentifier($jColumn);
                }
                $columns[] = $jColumns;
            }
        }

        if ($this->quantifier) {
            if ($this->quantifier instanceof Expression) {
                $quantifierParts = $this->processExpression($this->quantifier, $platform, $driver, 'quantifier');
                if ($parameterContainer) {
                    $parameterContainer->merge($quantifierParts->getParameterContainer());
                }
                $quantifier = $quantifierParts->getSql();
            } else {
                $quantifier = $this->quantifier;
            }
        }

        if (isset($quantifier)) {
            return array($quantifier, $columns, $table);
        } else {
            return array($columns, $table);
        }
    }
}
