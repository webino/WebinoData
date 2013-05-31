<?php

namespace WebinoData;

use Zend\Db\Sql\Predicate\PredicateSet;
use Zend\Db\Sql\Select;

class DataSelect
{
    protected $service;
    protected $sqlSelect;
    protected $subselects = array();

    public function __construct(DataService $service, Select $sqlSelect)
    {
        $this->service   = $service;
        $this->sqlSelect = $sqlSelect;
    }

    public function getSqlSelect()
    {
        return $this->sqlSelect;
    }

    public function getColumns()
    {
        return $this->getSqlSelect()->getRawState('columns');
    }

    public function columns(array $columns, $prefixColumnsWithTable = true)
    {
        foreach ($columns as $key => &$column) {

            if ($column instanceof self) {
                $this->subselect($key, $column);
            }
        }

        $this->sqlSelect->columns($columns, $prefixColumnsWithTable);
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

        $this->sqlSelect->where('(' . join(' AND ', $where) . ')', $combination);
        return $this;
    }
}
