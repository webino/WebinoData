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
    protected $search = array();
    protected $flags = array();

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

    public function getWhere()
    {
        return $this->sqlSelect->getRawState('where');
    }

    public function getOrder()
    {
        return $this->sqlSelect->getRawState('order');
    }

    public function getLimit()
    {
        return $this->sqlSelect->getRawState('limit');
    }

    public function getSearch()
    {
        return $this->search;
    }

    public function setFlag($name, $value = true)
    {
        if (null === $value) {
            unset($this->flags[$name]);
        }
        $this->flags[$name] = $value;
        return $this;
    }

    public function hasFlag($name)
    {
        if (empty($this->flags[$name])) {
            return false;
        }
        return true;
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
            ->setService($this->service)
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
            if (empty($this->subselects[$name])) {
                return null;
            }
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

        in_array($term, $this->search) or
            $this->search[] = $term;

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

    /**
     * Variable overloading
     *
     * @param  string $name
     * @throws \InvalidArgumentException
     * @return mixed
     */
    public function __get($name)
    {
        switch (strtolower($name)) {
            case 'where':
                return $this->sqlSelect->where;
            case 'having':
                return $this->sqlSelect->having;
            default:
                throw new \InvalidArgumentException('Not a valid magic property for this object');
        }
    }


    public function __toString()
    {
        return $this->getSqlString($this->service->getPlatform());
    }
}
