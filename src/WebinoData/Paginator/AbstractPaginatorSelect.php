<?php
/**
 * Webino (http://webino.sk)
 *
 * @link        https://github.com/webino/WebinoData for the canonical source repository
 * @copyright   Copyright (c) 2013-2017 Webino, s. r. o. (http://webino.sk)
 * @author      Peter Bačinský <peter@bacinsky.sk>
 * @license     BSD-3-Clause
 */

namespace WebinoData\Paginator;

use WebinoData\Select;
use WebinoData\Store\StoreInterface;
use Zend\Db\Sql\Expression;
use Zend\Paginator\Adapter\DbSelect;

/**
 * Class AbstractPaginatorSelect
 */
class AbstractPaginatorSelect extends DbSelect
{
    /**
     * @var Select
     */
    protected $dataSelect;

    /**
     * @var StoreInterface
     */
    protected $dataStore;

    /**
     * @var int
     */
    protected $overflow = 0;

    /**
     * @param Select $select
     * @param StoreInterface $dataStore
     */
    public function __construct(Select $select, StoreInterface $dataStore)
    {
        parent::__construct($select->getSqlSelect(), $dataStore->getAdapter());

        $this->dataSelect = $select;
        $this->dataStore  = $dataStore;
    }

    /**
     * @param int $overflow
     * @return $this
     */
    public function setOverflow($overflow)
    {
        $this->overflow = (int) $overflow;
        return $this;
    }

    /**
     * Returns an array of items for a page.
     *
     * @param int $offset Page offset
     * @param int $perPage Number of items per page
     * @return \ArrayObject
     */
    public function getItems($offset, $perPage)
    {
        $select = clone $this->dataSelect;
        $select->offset($offset);
        $select->limit($perPage + $this->overflow);
        $this->dataSelect->setHash($select->getHash());
        return $this->dataStore->fetchWith($select);
    }

    /**
     * Returns the total number of rows in the result set
     *
     * @return int
     */
    public function count()
    {
        if ($this->rowCount !== null) {
            return $this->rowCount;
        }

        $select = clone $this->dataSelect;
        $select->resetLimit();
        $select->resetOffset();
        $select->resetOrder();

        $columns = $select->getColumns();
        $columns['c'] = $this->resolveCountGroupExpression($select);
        $select->columns($columns);

        try {
            $result = $select->execute();
        } catch (\Throwable $exc) {
            // TODO better exception
            throw new \RuntimeException('Could not execute SQL ' . $sql, $exc->getCode(), $exc);
        }

        $row = $result->current();
        $resultCount = $result->count();
        $this->rowCount = 1 < $resultCount ? $resultCount : $row['c'];

        return $this->rowCount;
    }

    /**
     * @param Select $select
     * @return Expression
     */
    private function resolveCountGroupExpression(Select $select): Expression
    {
        $group = $select->getGroup();

        if (!empty($group)) {
            if (!is_string($group)) {
                $group = current($group);
                $group instanceof Expression and $group = $group->getExpression();
            }
        }

        return new Expression(is_string($group) ? 'COUNT(DISTINCT ' . $group . ')' : 'COUNT(*)');
    }
}
