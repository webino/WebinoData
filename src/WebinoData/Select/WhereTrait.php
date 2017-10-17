<?php

namespace WebinoData\Select;

use Zend\Db\Sql\Select;
use Zend\Db\Sql\Predicate\PredicateSet;

/**
 * Class WhereTrait
 */
trait WhereTrait
{
    /**
     * @var Where
     */
    protected $whereHelper;

    /**
     * @return Select
     */
    abstract public function getSqlSelect();

    /**
     * @return Where
     */
    public function getWhereHelper()
    {
        if (null == $this->whereHelper) {
            $this->whereHelper = new Where($this);
        }
        return $this->whereHelper;
    }

    /**
     * @param Where $whereHelper
     * @return $this
     */
    public function setWhereHelper(Where $whereHelper)
    {
        $this->whereHelper = $whereHelper;
        return $this;
    }

    /**
     * @see DataSelect::whereAnd();
     * @see DataSelect::whereOr();
     *
     * @param mixed $predicate
     * @param string $combination
     * @return $this
     */
    public function where($predicate, $combination = PredicateSet::OP_AND)
    {
        $this->getWhereHelper()->where($predicate, $combination);
        return $this;
    }

    /**
     * @param \Zend\Db\Sql\Where|\Closure|array|string $predicate
     * @return $this
     */
    public function whereAnd($predicate)
    {
        $this->where($predicate, PredicateSet::OP_AND);
        return $this;
    }

    /**
     * @param \Zend\Db\Sql\Where|\Closure|array|string $predicate
     * @return $this
     */
    public function whereOr($predicate)
    {
        $this->where($predicate, PredicateSet::OP_OR);
        return $this;
    }
}
