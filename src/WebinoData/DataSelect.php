<?php

namespace WebinoData;

use ArrayObject;
use WebinoData\DataSelect\ArrayColumn;
use Zend\Db\Sql\Predicate\Predicate;
use Zend\Db\Sql\Predicate\PredicateSet;
use Zend\Db\Sql\Expression;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Sql;

// todo refactor
class DataSelect
{
    const EXPRESSION_MARK = 'EXPRESSION:';

    protected $service;
    protected $sqlSelect;
    protected $subselects = [];
    protected $search = [];
    protected $flags = [];

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

    public function getJoins()
    {
        return $this->sqlSelect->getRawState('joins');
    }

    public function getWhere()
    {
        return $this->sqlSelect->getRawState('where');
    }

    public function getHaving()
    {
        return $this->sqlSelect->getRawState('having');
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

    public function hash()
    {
        return md5((string) $this);
    }

    public function columns(array $columns)
    {
        $serviceConfig = $this->service->getConfig();
        $tableName     = $this->service->getTableName();

        $inputFilter = $serviceConfig['input_filter'];
        unset($inputFilter['type']);

        // collect input column names
        foreach ($inputFilter as $input) {
            $input and $inputColumns[$input['name']] = new Expression(
                    '`' . $tableName . '`.`' . $input['name'] . '`'
                );
        }

        // replace star with input columns
        $starIndex = false;
        foreach ($columns as $index => $value) {
            if ('*' === $value) {
                $starIndex = $index;
                unset($index);
                unset($value);
                break;
            }
        }
        if (false !== $starIndex) {
            unset($columns[$starIndex]);
            $columns = array_merge($inputColumns, $columns);
        }

        // prefix id with table name
        $idIndex = false;
        foreach ($columns as $index => $value) {
            if ('id' === $value) {
                $idIndex = $index;
                unset($index);
                unset($value);
                break;
            }
        }
        if (false !== $idIndex) {

            $columns[$idIndex] = new Expression('`' . $tableName . '`.`id`');

            if (is_numeric($idIndex)) {
                // we need to change the index to a string
                // when we want to use an expression
                $keys            = array_keys($columns);
                $keyIndex        = array_search($idIndex, $keys);
                $keys[$keyIndex] = 'id';
                $columns         = array_combine($keys, array_values($columns));
            }
        }

        // manipulate columns
        foreach ($columns as $key => &$idColumn) {

            // fix an array column to be stringable
            if (is_array($idColumn)) {
                $idColumn = new ArrayColumn($idColumn);
                continue;
            }

            // store subselects
            if ($idColumn instanceof self) {
                $this->subselect($key, $idColumn);
                continue;
            }

            // use auto expression?
            !is_string($idColumn)
                or $idColumn = $this->autoExpression($idColumn);
        }

        $event = $this->service->getEvent();

        $event
            ->setSelect($this)
            ->setService($this->service)
            ->setParam('columns', $columns);

        $this->service->getEventManager()
            ->trigger('data.select.columns', $event);

        $this->sqlSelect->columns($event->getParam('columns'), false);
        return $this;
    }

    public function addColumns(array $columns)
    {
        $selectColumns = $this->getColumns();
        foreach ($columns as $key => $value) {
            $selectColumns[$key] = $value;
        }
        $this->columns($selectColumns);
        return $this;
    }

    public function addColumn($name, $value)
    {
        $columns = array_replace(
            $this->getColumns(),
            [$name => $value]
        );
        $this->columns($columns);
        return $this;
    }

    public function removeColumn($name)
    {
        $columns = $this->getColumns();
        if (isset($columns[$name])) {
            unset($columns[$name]);
        }
        $this->columns($columns);
        return $this;
    }

    public function limit($limit)
    {
        $this->sqlSelect->limit((int) $limit);
        return $this;
    }

    public function join($name, $on, $columns = Select::SQL_STAR, $type = Select::JOIN_INNER)
    {
        if (is_array($columns)) {
            array_walk($columns, function (&$value) {
                $value = $this->autoExpression($value);
            });
        }
        $this->sqlSelect->join($name, $this->autoExpression($on), $columns, $type);
        return $this;
    }

    public function offset($offset)
    {
        $this->sqlSelect->offset((int) $offset);
        return $this;
    }

    public function order($order)
    {
        if (is_string($order) && strpos($order, '(')) {
            $order = new Expression($order);
        }

        $this->sqlSelect->order($order);
        return $this;
    }

    // todo decouple (redesign)
    private function replaceVars(array &$subject)
    {
        foreach ($subject as &$str) {
            if (is_object($str)) {
                // todo replace in sql select?
                continue;
            }

            if (is_array($str)) {
                $this->replaceVars($str);
                continue;
            }

            if (false !== strpos($str, '{$tableName}')) {
                $str = str_replace('{$tableName}', $this->service->getTableName(), $str);
            }
        }

        return $this;
    }

    // todo decouple (redesign)
    private function parsePredicate($predicate)
    {
        $newPredicate = [];
        foreach ($predicate as $key => $value) {
            $args = [$key, $value];
            $this->replaceVars($args);
            $newPredicate[$args[0]] = $args[1];
        }

        return $newPredicate;
    }

    public function where($predicate, $combination = PredicateSet::OP_AND)
    {
        is_object($predicate)
            or $predicate = new ArrayObject($predicate);

        $event = $this->service->getEvent();

        $event
            ->setSelect($this)
            ->setService($this->service)
            ->setParam('predicate', $predicate)
            ->setParam('combination', $combination);

        $this->service->getEventManager()
            ->trigger('data.select.where', $event);

        // todo refactor parsePredicate()
        $this->sqlSelect->where($this->parsePredicate($predicate), $combination);

        return $this;
    }

    public function having($predicate, $combination = PredicateSet::OP_AND)
    {
        $this->sqlSelect->having($predicate, $combination);
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

    // todo decouple logic
    public function search($term, array $columns = [], $combination = PredicateSet::OP_AND)
    {
        if (empty($term) && !is_numeric($term)) {
            return $this;
        }

        if (is_array($term)) {
            foreach ($term as $subKey => $subTerms) {
                foreach ((array) $subTerms as $subTerm) {

                    empty($subKey) || (empty($subTerm) && !is_numeric($subTerm))
                        or $this->search($subTerm, [$subKey], $combination);
                }
            }
            return $this;
        }

        $term     = $this->sanitizeSearchTerm($term);
        $platform = $this->service->getPlatform();
        $where    = new ArrayObject;
        $having   = new ArrayObject;
        $joinCols = array_column($this->getJoins(), 'columns');

        foreach (explode(' ', $term) as $word) {
            if (empty($word) && !is_numeric($word)) {
                continue;
            }

            foreach ($columns as $column) {
                $columnParts = explode('.', $column);
                $identifier  = (2 === count($columnParts))
                                ? $platform->quoteIdentifier($columnParts[0])
                                  . '.' . $platform->quoteIdentifier($columnParts[1])
                                : $platform->quoteIdentifier($column);

                if (preg_match('~_id$~', $column)) {
                    // id column
                    $where[] = $identifier . ' = ' . $platform->quoteValue($word);
                    continue;
                }

                $word     = $this->sanitizeSearchTerm($word, '%');
                $joinCol  = current(array_column($joinCols, $column));
                $isHaving = (!empty($joinCol) && $joinCol instanceof Expression);
                $target   = ($isHaving ? $having : $where);
                $target[] = $identifier . ' LIKE ' . $platform->quoteValue('%' . $word . '%');
            }
        }

        if (!count($where) && !count($having)) {
            return $this;
        }

        foreach ($columns as $column) {
            isset($this->search[$column])  or $this->search[$column] = [];
            in_array($term, $this->search) or $this->search[$column][] = $term;
        }

        $predicate = function (ArrayObject $columns) {
            return '(' . join(' ' . PredicateSet::OP_OR . ' ', $columns->getArrayCopy()) . ')';
        };

        count($where)  and $this->sqlSelect->where($predicate($where), $combination);
        count($having) and $this->sqlSelect->having($predicate($having), $combination);

        return $this;
    }

    // todo decouple
    private function sanitizeSearchTerm($term, $replacement = ' ')
    {
        // todo trigger event instead
        $this->fixDateSearch($term);

        return preg_replace('~[^a-zA-Z0-9_-]+~', $replacement, $term);
    }

    // TODO decouple
    private function fixDateSearch(&$term)
    {
        if (!preg_match('~^[0-9]{1,2}\.[0-9]{1,2}(\.[0-9]{1,4})?$~', $term)) {
            return;
        }
        // fix year
        substr_count($term, '.') >= 3 or $term.= '.';
        list($day, $month, $year) = explode('.', $term);
        $term = sprintf(
            '%s-%s-%s',
            $year,
            str_repeat('0', 2 - strlen($month)) . $month,
            str_repeat('0', 2 - strlen($day)) . $day
        );
    }

    public function group($group)
    {
        $this->sqlSelect->group($group);
        return $this;
    }

    /**
     * @return string
     */
    public function getSqlString()
    {
        return $this->service->getSql()->getSqlStringForSqlObject($this->sqlSelect, $this->service->getPlatform());
    }

    /**
     * @param string $part
     * @return Select
     */
    public function reset($part)
    {
        return $this->sqlSelect->reset($part);
    }

    public function configure(array $config)
    {
        if (isset($config['columns'])) {
            // todo prefixColumnsWithTable deprecated
            $columns = current($config['columns']);
            $prefixColumnsWithTable = (2 === count($config['columns'])) ? next($config['columns']) : false;

            $this->columns($columns, $prefixColumnsWithTable);
        }

        $this->configureWhere($config, $this->where, 'where');
        $this->configureWhere($config, $this->having, 'having');

        if (!empty($config['join'])) {
            foreach ($config['join'] as $join) {
                call_user_func_array([$this, 'join'], $join);
            }
        }

        empty($config['order'])  or $this->order($config['order']);
        empty($config['limit'])  or $this->limit($config['limit']);
        empty($config['offset']) or $this->offset($config['offset']);
        empty($config['group'])  or $this->group($config['group']);

        return $this;
    }

    // todo remain predicates
    private function configureWhere(array $config, Predicate $where, $key)
    {
        if (!empty($config[$key])) {
            $predicate = current($config[$key]);
            $combination = (2 === count($config[$key]))
                            ? next($config[$key])
                            : PredicateSet::OP_AND;

            $this->{$key}($predicate, $combination);

        }

        empty($config[$key . 'EqualTo'])
            or $this->processPredicate(
                'equalTo',
                $config,
                $where,
                $key
            );

        empty($config[$key . 'NotEqualTo'])
            or $this->processPredicate(
                'notEqualTo',
                $config,
                $where,
                $key
            );

        empty($config[$key . 'LessThanOrEqualTo'])
            or $this->processPredicate(
                'lessThanOrEqualTo',
                $config,
                $where,
                $key
            );

        empty($config[$key . 'GreaterThanOrEqualTo'])
            or $this->processPredicate(
                'greaterThanOrEqualTo',
                $config,
                $where,
                $key
            );

        empty($config[$key . 'Nest'])
            or $this->whereNest($config[$key . 'Nest'], $where, $key);

        return $this;
    }

    public function execute(Sql $sql, $parameters = [])
    {
        try {
            return $sql->prepareStatementForSqlObject($this->sqlSelect)
                        ->execute($parameters);

        } catch (\Exception $exc) {
            throw new Exception\RuntimeException(
                sprintf(
                    'Statement could not be executed %s',
                    $sql->getSqlStringForSqlObject($this->sqlSelect, $this->service->getPlatform())
                ) . '; ' . $exc->getPrevious()->getMessage(),
                $exc->getCode(),
                $exc
            );
        }
    }

    private function resolveOperatorArgs($predicate)
    {
        $left      = $this->autoExpression(key($predicate));
        $right     = $this->autoExpression(current($predicate));
        $op        = strtolower(!empty($predicate['op']) ? $predicate['op'] : PredicateSet::OP_AND);
        $leftType  = !empty($predicate['leftType']) ? $predicate['leftType'] : Expression::TYPE_IDENTIFIER;
        $rightType = !empty($predicate['rightType']) ? $predicate['rightType'] : Expression::TYPE_VALUE;

        return [$left, $right, $op, $leftType, $rightType];
    }

    private function autoExpression($value)
    {
        // detect expression
        if (0 === strpos($value, self::EXPRESSION_MARK)) {
            return new Expression(substr($value, strlen(self::EXPRESSION_MARK)));
        }
        return $value;
    }

    private function processPredicate($type, array $config, Predicate $where, $key = 'where')
    {
        foreach ($config[$key . ucfirst($type)] as $predicate) {

            list($left, $right, $op, $leftType, $rightType) = $this->resolveOperatorArgs($predicate);
            $where->{$op}->{$type}($left, $right, $leftType, $rightType);
        }

        return $this;
    }

    private function whereNest($config, Predicate $where, $key)
    {
        $op = strtolower(!empty($config['op']) ? $config['op'] : PredicateSet::OP_AND);
        $this->configureWhere($config, $where->{$op}->nest(), $key);
        return $this;
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
        try {
            return $this->getSqlString();
        } catch (\Exception $exc) {
            return $exc;
        }
    }
}
