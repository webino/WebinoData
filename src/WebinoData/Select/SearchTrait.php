<?php

namespace WebinoData\Select;

use Zend\Db\Sql\Predicate\PredicateSet;

/**
 * Class SearchTrait
 */
trait SearchTrait
{
    /**
     * @return Search
     */
    abstract public function getSearchHelper();

    /**
     * @return array
     */
    public function getSearch()
    {
        return $this->getSearchHelper()->getSearch();
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
}
