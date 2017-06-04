<?php

namespace WebinoData;

use ArrayObject;
use WebinoData\DataSelect\ArrayColumn;
use WebinoData\Select\Search;
use Zend\Db\Sql\Predicate\Predicate;
use Zend\Db\Sql\Predicate\PredicateSet;
use Zend\Db\Sql\Expression;
use Zend\Db\Sql\Select;
use Zend\Db\Sql\Sql;

/**
 * Class DataSelect
 * @todo refactor/redesign
 */
class DataSelect
{
    const EXPRESSION_MARK = 'EXPRESSION:';

    /**
     * @var AbstractDataService
     */
    protected $store;

    /**
     * @var Select
     */
    protected $sqlSelect;

    /**
     * @var DataEvent
     */
    protected $event;

    /**
     * @var array
     */
    protected $subSelects = [];

    /**
     * @var array
     */
    protected $subParams = [];

    /**
     * @var array
     */
    protected $flags = [];

    /**
     * @var Search
     */
    protected $searchHelper;

    /**
     * @var string|null
     */
    protected $hash;

    /**
     * @param AbstractDataService $store
     * @param Select $select
     */
    public function __construct(AbstractDataService $store, Select $select)
    {
        $this->store = $store;
        $this->sqlSelect = $select;
    }

    /**
     * @return AbstractDataService
     */
    public function getStore()
    {
        return $this->store;
    }

    /**
     * @return Select
     */
    public function getSqlSelect()
    {
        return $this->sqlSelect;
    }

    /**
     * @return DataEvent
     */
    public function getEvent()
    {
        if (null === $this->event) {
            $this->event = clone $this->store->getEvent();
            $this->event->setSelect($this)->setStore($this->store);
        }
        return $this->event;
    }

    /**
     * @return Search
     */
    public function getSearchHelper()
    {
        if (null === $this->searchHelper) {
            $this->searchHelper = new Search($this);
        }
        return $this->searchHelper;
    }

    /**
     * @param Search $searchHelper
     * @return $this
     */
    public function setSearchHelper($searchHelper)
    {
        $this->searchHelper = $searchHelper;
        return $this;
    }

    /**
     * @return array
     */
    public function getColumns()
    {
        return $this->sqlSelect->getRawState('columns');
    }

    /**
     * @return array
     */
    public function getJoins()
    {
        return $this->sqlSelect->getRawState('joins');
    }

    /**
     * @return array
     */
    public function getWhere()
    {
        return $this->sqlSelect->getRawState('where');
    }

    /**
     * @return array
     */
    public function getHaving()
    {
        return $this->sqlSelect->getRawState('having');
    }

    /**
     * @return array
     */
    public function getGroup()
    {
        return $this->sqlSelect->getRawState('group');
    }

    /**
     * @return array
     */
    public function getOrder()
    {
        return $this->sqlSelect->getRawState('order');
    }

    /**
     * @return array
     */
    public function getLimit()
    {
        return $this->sqlSelect->getRawState('limit');
    }

    /**
     * @return array
     */
    public function getSearch()
    {
        return $this->getSearchHelper()->getSearch();
    }

    /**
     * @param string $name
     * @param bool|true $value
     * @return $this
     */
    public function setFlag($name, $value = true)
    {
        if (null === $value) {
            unset($this->flags[(string) $name]);
        }
        $this->flags[(string) $name] = (bool) $value;
        return $this;
    }

    /**
     * @param string $name
     * @return bool
     */
    public function hasFlag($name)
    {
        return !empty($this->flags[(string) $name]);
    }

    /**
     * @return string
     */
    public function getHash()
    {
        return md5((string) $this . serialize($this->subParams) . serialize($this->flags) . $this->hash);
    }

    /**
     * @TODO remove
     * @deprecated, use getHash() instead
     * @return string
     */
    public function hash()
    {
        return $this->getHash();
    }

    /**
     * @param string|null $hash
     * @return $this
     */
    public function setHash($hash)
    {
        $this->hash .= is_array($hash) ? md5(serialize($hash)) : $hash;
        return $this;
    }

    /**
     * @param array $columns
     * @return $this
     */
    public function columns(array $columns)
    {
        $serviceConfig = $this->store->getConfig();
        $tableName     = $this->store->getTableName();

        $inputFilter = $serviceConfig['input_filter'];
        unset($inputFilter['type']);

        // collect input column names
        $inputColumns = [];
        foreach ($inputFilter as $input) {
            if ($input) {
                $inputColumns[$input['name']] = new Expression(
                    '`' . $tableName . '`.`' . $input['name'] . '`'
                );
            }
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

            // fix an array column to be string-able
            if (is_array($idColumn)) {
                $idColumn = new ArrayColumn($idColumn);
                continue;
            }

            // store subSelects
            if ($idColumn instanceof self) {
                $this->subSelect($key, $idColumn);
                continue;
            }

            // use auto expression?
            is_string($idColumn) and $idColumn = $this->autoExpression($idColumn);
        }

        $event = $this->getEvent();
        $event->setParam('columns', $columns);

        $this->store->getEventManager()
            ->trigger('data.select.columns', $event);

        $this->sqlSelect->columns($event->getParam('columns'), false);
        return $this;
    }

    /**
     * @param array $columns
     * @return $this
     */
    public function addColumns(array $columns)
    {
        $selectColumns = $this->getColumns();
        foreach ($columns as $key => $value) {
            $selectColumns[$key] = $value;
        }
        $this->columns($selectColumns);
        return $this;
    }

    /**
     * @param string $name
     * @param string|array $value
     * @return $this
     */
    public function addColumn($name, $value)
    {
        $columns = array_replace($this->getColumns(), [$name => $value]);
        $this->columns($columns);
        return $this;
    }

    /**
     * @param string $name
     * @return $this
     */
    public function removeColumn($name)
    {
        $columns = $this->getColumns();
        if (isset($columns[$name])) {
            unset($columns[$name]);
        }
        $this->columns($columns);
        return $this;
    }

    /**
     * @param string $limit
     * @return $this
     */
    public function limit($limit)
    {
        $this->sqlSelect->limit((int) $limit);
        return $this;
    }

    /**
     * @param string|array $name
     * @param string $on
     * @param string|array $columns
     * @param string $type
     * @return $this
     */
    public function join($name, $on, $columns = Select::SQL_STAR, $type = Select::JOIN_INNER)
    {
        if (is_array($columns)) {
            array_walk($columns, function (&$value) {
                $value = $this->autoExpression($value);
            });
        }

        $event = $this->getEvent();
        $event->setParam('on', $on);

        $this->store->getEventManager()
            ->trigger('data.select.join', $event);

        $this->sqlSelect->join($name, $this->autoExpression($event->getParam('on')), $columns, $type);
        return $this;
    }

    /**
     * @param int $offset
     * @return $this
     */
    public function offset($offset)
    {
        $this->sqlSelect->offset((int) $offset);
        return $this;
    }

    /**
     * @param string|array $order
     * @return $this
     */
    public function order($order)
    {
        $platform = $this->store->getPlatform();
        $cols     = $this->getColumns();
        $trick    = 'CAST(%s as UNSIGNED)';

        $_order = [];
        $parts  = is_array($order) ? $order : explode(',', $order);
        foreach ($parts as $value) {
            $value = trim($value);

            // handle function expression
            if (strpos($value, '(')) {
                $_order[] = $value;
                continue;
            }

            // handle column without order type
            if (false === strpos($value, ' ')) {
                $key = $platform->quoteIdentifierChain(explode('.', $value));
                $_order[] = sprintf($trick, $key);
                $_order[] = $key;
                continue;
            }

            list($col, $type) = explode(' ', $value);

            // handle expression column
            if (!empty($cols[$col]) && $cols[$col] instanceof Expression) {
                /** @var Expression $expr */
                $expr = $cols[$col];
                if (strpos($expr->getExpression(), '(')) {
                    $_order[] = $platform->quoteIdentifierChain(explode('.', $col));
                    continue;
                }
            }

            // natural sorting workaround
            $key = $platform->quoteIdentifierChain(explode('.', $col));
            $_order[] = sprintf($trick, $key) . ' ' . $type;
            $_order[] = $key . ' ' . $type;
        }

        $order = join(', ', $_order);
        $this->replaceVars($order);
        $this->sqlSelect->order(new Expression($order));

        return $this;
    }

    /**
     * @param array $subject
     * @return $this
     * @todo decouple (redesign)
     */
    private function replaceVars(&$subject)
    {
        if (is_string($subject)) {
            $this->replaceVarsInternal($subject);
            return $this;
        }

        foreach ($subject as &$str) {
            if (is_object($str)) {
                // todo replace in sql select?
                continue;
            }

            if (is_array($str)) {
                $this->replaceVars($str);
                continue;
            }

            $this->replaceVarsInternal($str);
        }

        return $this;
    }

    /**
     * @param string &$str
     * @return $this
     */
    private function replaceVarsInternal(&$str)
    {
        // TODO remove, {$tableName} deprecated, use {$this}
        if (false !== strpos($str, '{$tableName}')) {
            $str = str_replace('{$tableName}', $this->store->getTableName(), $str);
        }
        if (false !== strpos($str, '{$this}')) {
            $str = str_replace('{$this}', $this->store->getTableName(), $str);
        }
        return $this;
    }

    /**
     * @param array|ArrayObject $predicate
     * @return array
     * @todo decouple (redesign)
     */
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

    /**
     * @param mixed $predicate
     * @param string $combination
     * @return $this
     */
    public function where($predicate, $combination = PredicateSet::OP_AND)
    {
        is_object($predicate)
            or $predicate = new ArrayObject((array) $predicate);

        $event = $this->store->getEvent();

        $event
            ->setSelect($this)
            ->setStore($this->store)
            ->setParam('predicate', $predicate)
            ->setParam('combination', $combination);

        $this->store->getEventManager()
            ->trigger('data.select.where', $event);

        // todo refactor parsePredicate()
        $this->sqlSelect->where($this->parsePredicate($predicate), $combination);

        return $this;
    }

    /**
     * @param mixed $predicate
     * @param string $combination
     * @return $this
     */
    public function having($predicate, $combination = PredicateSet::OP_AND)
    {
        $this->sqlSelect->having($predicate, $combination);
        return $this;
    }

    /**
     * @param string $name
     * @param string $key
     * @param string $value
     * @return $this
     */
    public function havingRelation($name, $key, $value)
    {
        // TODO DRY
        $this->having([$key . '_id' => $value]);
        $this->subParams($name, [$key . '_id' => $value]);
        return $this;
    }

    /**
     * @param string $name
     * @param DataSelect|null $select
     * @return $this|null
     */
    public function subSelect($name, self $select = null)
    {
        if (null === $select) {
            return !empty($this->subSelects[$name]) ? $this->subSelects[$name] : null;
        }

        $subSelect = $select;
        $subSelect->setHash($this->hash());
        $this->subSelects[$name] = $subSelect;

        return $this;
    }

    /**
     * @param string $name
     * @param array $params
     * @return $this
     */
    public function subParams($name, array $params = [])
    {
        if (empty($params)) {
            return isset($this->subParams[$name]) ? $this->subParams[$name] : [];
        }

        isset($this->subParams[$name]) or $this->subParams[$name] = [];
        $this->subParams[$name] = array_replace($this->subParams[$name], $params);

        return $this;
    }

    /**
     * @param mixed $term
     * @param array $columns
     * @param string $combination
     * @return $this
     */
    public function search($term, array $columns = [], $combination = PredicateSet::OP_AND)
    {
        $this->getSearchHelper()->search($term, $columns, $combination);
        return $this;
    }

    /**
     * @param string $group
     * @return $this
     */
    public function group($group)
    {
        $this->sqlSelect->group($this->autoExpression($group));
        return $this;
    }

    /**
     * @param self $select
     * @param string $type
     * @param string $modifier
     * @return $this
     */
    public function combine(self $select, $type = Select::COMBINE_UNION, $modifier = '')
    {
        $this->sqlSelect->combine($select->getSqlSelect(), $type, $modifier);
        return $this;
    }

    /**
     * @return string
     */
    public function getSqlString()
    {
        return $this->store->getSql()->buildSqlString($this->sqlSelect);
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
     * @param array $config
     * @return $this
     */
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

    /**
     * @param array $config
     * @param Predicate $where
     * @param string $key
     * @return $this
     * @todo remain predicates
     */
    private function configureWhere(array $config, Predicate $where, $key)
    {
        if (!empty($config[$key])) {
            $predicate = current($config[$key]);
            $combination = (2 === count($config[$key]))
                            ? next($config[$key])
                            : PredicateSet::OP_AND;

            $this->{$key}($predicate, $combination);

        }

        // TODO support all predicate methods

        empty($config[$key . 'IsNull'])
            or $this->processPredicate(
                'isNull',
                $config,
                $where,
                $key
            );

        empty($config[$key . 'IsNotNull'])
            or $this->processPredicate(
                'isNotNull',
                $config,
                $where,
                $key
            );

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

        empty($config[$key . 'In'])
            or $this->processPredicate(
                'in',
                $config,
                $where,
                $key
            );

        empty($config[$key . 'NotIn'])
            or $this->processPredicate(
                'notIn',
                $config,
                $where,
                $key
            );

        empty($config[$key . 'Nest'])
            or $this->whereNest($config[$key . 'Nest'], $where, $key);

        return $this;
    }

    /**
     * @param Sql $sql
     * @param array $parameters
     * @return \Zend\Db\Adapter\Driver\ResultInterface
     */
    public function execute(Sql $sql, $parameters = [])
    {
        try {
            return $sql->prepareStatementForSqlObject($this->sqlSelect)
                        ->execute($parameters);

        } catch (\Exception $exc) {
            throw new Exception\RuntimeException(
                sprintf(
                    'Statement could not be executed %s',
                    $sql->buildSqlString($this->sqlSelect)
                ) . '; ' . $exc->getPrevious()->getMessage(),
                $exc->getCode(),
                $exc
            );
        }
    }

    /**
     * @param array|ArrayObject $predicate
     * @return array
     */
    private function resolveOperatorArgs($predicate)
    {
        $left      = $this->autoExpression(key($predicate));
        $right     = $this->autoExpression(current($predicate));
        $op        = strtolower(!empty($predicate['op']) ? $predicate['op'] : PredicateSet::OP_AND);
        $leftType  = !empty($predicate['leftType']) ? $predicate['leftType'] : Expression::TYPE_IDENTIFIER;
        $rightType = !empty($predicate['rightType']) ? $predicate['rightType'] : Expression::TYPE_VALUE;

        return [$left, $right, $op, $leftType, $rightType];
    }

    /**
     * @param string|Expression $value
     * @return Expression
     */
    private function autoExpression($value)
    {
        // detect expression
        if (is_string($value) && 0 === strpos($value, self::EXPRESSION_MARK)) {
            return new Expression(substr($value, strlen(self::EXPRESSION_MARK)));
        }
        return $value;
    }

    /**
     * @param string $type
     * @param array $config
     * @param Predicate $where
     * @param string $key
     * @return $this
     */
    private function processPredicate($type, array $config, Predicate $where, $key = 'where')
    {
        foreach ($config[$key . ucfirst($type)] as $predicate) {

            list($left, $right, $op, $leftType, $rightType) = $this->resolveOperatorArgs($predicate);
            $where->{$op}->{$type}($left, $right, $leftType, $rightType);
        }

        return $this;
    }

    /**
     * @param array $config
     * @param Predicate $where
     * @param string $key
     * @return $this
     */
    private function whereNest(array $config, Predicate $where, $key)
    {
        $op = strtolower(!empty($config['op']) ? $config['op'] : PredicateSet::OP_AND);
        $this->configureWhere($config, $where->{$op}->nest(), $key);
        return $this;
    }

    /**
     * Variable overloading
     *
     * @param string $name
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
                // TODO exception
                throw new \InvalidArgumentException('Not a valid magic property `' . $name . '`` for this object');
        }
    }

    /**
     * @return \Exception|string
     */
    public function __toString()
    {
        try {
            return $this->getSqlString();
        } catch (\Exception $exc) {
            // TODO use logger
            error_log($exc);
        }

        return '';
    }

    /**
     * Clone data select
     */
    public function __clone()
    {
        $this->sqlSelect = clone $this->sqlSelect;
    }
}
