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
use Zend\Db\Sql\Predicate\Predicate;
use Zend\Db\Sql\Predicate\PredicateSet;

/**
 * Class Configure
 */
class Configure extends AbstractHelper
{
    use ExpressionTrait;
    use PredicateTrait;

    /**
     * @return \WebinoData\Store\StoreInterface
     */
    public function getStore()
    {
        return $this->select->getStore();
    }

    /**
     * @param array $config
     * @return $this
     */
    public function configure(array $config)
    {
        if (isset($config['columns'])) {
            $columns = current($config['columns']);
            $this->select->columns($columns);
        }

        $this->configureWhere($config, $this->select->where, 'where');
        $this->configureWhere($config, $this->select->having, 'having');

        if (!empty($config['join'])) {
            foreach ($config['join'] as $join) {
                call_user_func_array([$this->select, 'join'], $join);
            }
        }

        empty($config['order'])  or $this->select->order($config['order']);
        empty($config['limit'])  or $this->select->limit($config['limit']);
        empty($config['offset']) or $this->select->offset($config['offset']);
        empty($config['group'])  or $this->select->group($config['group']);

        return $this;
    }

    /**
     * @todo remaining predicates
     *
     * @param array $config
     * @param Predicate $where
     * @param string $key
     * @return $this
     */
    private function configureWhere(array $config, Predicate $where, $key)
    {
        if (!empty($config[$key])) {
            $predicate = current($config[$key]);
            $combination = (2 === count($config[$key]))
                ? next($config[$key])
                : PredicateSet::OP_AND;

            $this->select->{$key}($predicate, $combination);
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
     * @param \ArrayObject|array $predicate
     * @return array
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
}
