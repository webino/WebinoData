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

use Zend\Db\Sql\Select;
use Zend\Db\Sql\Predicate\PredicateSet;

/**
 * Class HavingTrait
 */
trait HavingTrait
{
    /**
     * @return Select
     */
    abstract public function getSqlSelect();

    /**
     * Set sub-select params
     *
     * @param string $name
     * @param array $params
     * @return $this
     */
    abstract public function setSubParams($name, array $params);

    /**
     * @see DataSelect::havingAnd()
     * @see DataSelect::havingOr()
     *
     * @param \Zend\Db\Sql\Where|\Closure|array|string $predicate
     * @param string $combination
     * @return $this
     */
    public function having($predicate, $combination = PredicateSet::OP_AND)
    {
        $this->getSqlSelect()->having($predicate, $combination);
        return $this;
    }

    /**
     * @param \Zend\Db\Sql\Where|\Closure|array|string $predicate
     * @return $this
     */
    public function havingAnd($predicate)
    {
        return $this->having($predicate, PredicateSet::OP_AND);
    }

    /**
     * @param \Zend\Db\Sql\Where|\Closure|array|string $predicate
     * @return $this
     */
    public function havingOr($predicate)
    {
        return $this->having($predicate, PredicateSet::OP_OR);
    }

    /**
     * @param string $name
     * @param string $key
     * @param string $value
     * @return $this
     */
    public function havingRelation($name, $key, $value)
    {
        $params = [$key . '_id' => $value];
        $this->having($params);
        $this->setSubParams($name, $params);
        return $this;
    }
}
