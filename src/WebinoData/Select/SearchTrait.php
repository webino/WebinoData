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

use Zend\Db\Sql\Predicate\PredicateSet;

/**
 * Class SearchTrait
 */
trait SearchTrait
{
    /**
     * @var Search
     */
    protected $searchHelper;

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
    public function setSearchHelper(Search $searchHelper)
    {
        $this->searchHelper = $searchHelper;
        return $this;
    }

    /**
     * @return array
     */
    public function getSearch()
    {
        return $this->getSearchHelper()->getSearch();
    }

    /**
     * @see SearchTrait::searchAnd()
     * @see SearchTrait::searchOr()
     *
     * @param string|array $term
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
     * @param string|array $term
     * @param array $columns
     * @return $this
     */
    public function searchAnd($term, array $columns = [])
    {
        return $this->search($term, $columns, PredicateSet::OP_AND);
    }

    /**
     * @param string|array $term
     * @param array $columns
     * @return $this
     */
    public function searchOr($term, array $columns = [])
    {
        return $this->search($term, $columns, PredicateSet::OP_OR);
    }
}
