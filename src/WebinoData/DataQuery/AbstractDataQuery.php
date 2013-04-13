<?php

namespace WebinoData\DataQuery;

use Zend\Db\Adapter\Platform\PlatformInterface;
use Zend\Db\Sql\Predicate;
use Zend\Db\Sql\SqlInterface;

abstract class AbstractDataQuery
{
    protected $sql;
    protected $platform;

    public function __construct(SqlInterface $sql, PlatformInterface $platform)
    {
        $this->sql      = $sql;
        $this->platform = $platform;
    }

    /**
     * Create where clause
     *
     * @param  Where|\Closure|string|array $predicate
     * @param  string $combination One of the OP_* constants from Predicate\PredicateSet
     * @throws Exception\InvalidArgumentException
     * @return Select
     */
    public function where($predicate, $combination = Predicate\PredicateSet::OP_AND)
    {
        $this->sql->where($predicate, $combination);
        return $this;
    }
}
