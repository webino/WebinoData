<?php

namespace WebinoData;

use ArrayObject;
use WebinoData\Select\Columns;
use WebinoData\Select\Search;
use WebinoData\Select\ColumnsTrait;
use WebinoData\Select\ExpressionTrait;
use WebinoData\Select\RawStateTrait;
use WebinoData\Select\ResetTrait;
use WebinoData\Select\SearchTrait;
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
    use ColumnsTrait;
    use ExpressionTrait;
    use RawStateTrait;
    use ResetTrait;
    use SearchTrait;

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
     * @var Columns
     */
    protected $columnsHelper;

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
     * @return Columns
     */
    public function getColumnsHelper()
    {
        if (null === $this->columnsHelper) {
            $this->columnsHelper = new Columns($this);
        }
        return $this->columnsHelper;
    }

    /**
     * @param Columns $columnsHelper
     * @return $this
     */
    public function setColumnsHelper(Columns $columnsHelper)
    {
        $this->columnsHelper = $columnsHelper;
        return $this;
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
                $value = $this->handleExpression($value);
            });
        }

        $event = $this->getEvent();
        $event->setParam('on', $on);

        $this->store->getEventManager()
            ->trigger('data.select.join', $event);

        $this->sqlSelect->join($name, $this->handleExpression($event->getParam('on')), $columns, $type);
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
     * @TODO decouple to helper
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
        $subSelect->setHash($this->getHash());
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
     * @param string $group
     * @return $this
     */
    public function group($group)
    {
        $this->sqlSelect->group($this->handleExpression($group));
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
     * @return $this
     * @TODO remove, deprecated
     * @deprecated, use methods like resetWhere() etc. from ResetTrait
     */
    public function reset($part)
    {
        $this->sqlSelect->reset($part);
        return $this;
    }

    /**
     * @param array $config
     * @return $this
     * @TODO decouple to helper
     */
    public function configure(array $config)
    {
        if (isset($config['columns'])) {
            $columns = current($config['columns']);
            $this->columns($columns);
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
     * @TODO decouple to helper
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
     * @TODO decouple to helper
     */
    private function resolveOperatorArgs($predicate)
    {
        $left      = $this->handleExpression(key($predicate));
        $right     = $this->handleExpression(current($predicate));
        $op        = strtolower(!empty($predicate['op']) ? $predicate['op'] : PredicateSet::OP_AND);
        $leftType  = !empty($predicate['leftType']) ? $predicate['leftType'] : Expression::TYPE_IDENTIFIER;
        $rightType = !empty($predicate['rightType']) ? $predicate['rightType'] : Expression::TYPE_VALUE;

        return [$left, $right, $op, $leftType, $rightType];
    }

    /**
     * @param string $type
     * @param array $config
     * @param Predicate $where
     * @param string $key
     * @return $this
     * @TODO decouple to helper
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
     * @TODO decouple to helper
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

        if ($this->columnsHelper) {
            $this->columnsHelper = clone $this->columnsHelper;
            $this->columnsHelper->setSelect($this);
        }

        if ($this->searchHelper) {
            $this->searchHelper = clone $this->searchHelper;
            $this->searchHelper->setSelect($this);
        }
    }
}
