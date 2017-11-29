<?php
/**
 * Webino (http://webino.sk)
 *
 * @link        https://github.com/webino/WebinoData for the canonical source repository
 * @copyright   Copyright (c) 2013-2017 Webino, s. r. o. (http://webino.sk)
 * @author      Peter Bačinský <peter@bacinsky.sk>
 * @license     BSD-3-Clause
 */

namespace WebinoData\Query;

use Zend\Db\Adapter\Platform\PlatformInterface;
use Zend\Db\Sql;

/**
 * Class AbstractUpdate
 */
abstract class AbstractUpdate extends AbstractQuery
{
    /**
     * @var array
     */
    protected $columns = [];

    /**
     * @param string $identifier
     * @param string $value
     * @return Sql\Expression
     */
    abstract protected function createExpression($identifier, $value);

    /**
     * @param Sql\Update $sql
     * @param PlatformInterface $platform
     */
    public function __construct(Sql\Update $sql, PlatformInterface $platform)
    {
        parent::__construct($sql, $platform);
    }

    /**
     * @return Sql\Update|Sql\AbstractPreparableSql
     */
    public function getSql()
    {
        return parent::getSql();
    }

    /**
     * @return array
     */
    public function getColumns()
    {
        return $this->columns;
    }

    /**
     * @param array|string $columns
     * @return $this
     */
    public function setColumns($columns)
    {
        $this->columns = (array) $columns;
        return $this;
    }

    /**
     * Create where clause
     *
     * @param  Sql\Where|\Closure|string|array $predicate
     * @param  string $combination One of the OP_* constants from Predicate\PredicateSet
     * @throws \Zend\Db\Sql\Exception\InvalidArgumentException
     * @return $this
     */
    public function where($predicate, $combination = Sql\Predicate\PredicateSet::OP_AND)
    {
        $this->getSql()->where($predicate, $combination);
        return $this;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        $columns = $this->columns;
        $set = [];

        foreach ($columns as $column => $value) {

            $column       = !is_numeric($column) ? $column : $value;
            $identifier   = $this->platform->quoteIdentifier($column);
            $set[$column] = $this->createExpression($identifier, $value);
        }

        $this->getSql()->set($set);
        return parent::__toString();
    }
}
