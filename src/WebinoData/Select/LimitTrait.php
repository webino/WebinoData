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

/**
 * Class LimitTrait
 */
trait LimitTrait
{
    /**
     * @return Select
     */
    abstract public function getSqlSelect();

    /**
     * @param string $limit
     * @return $this
     */
    public function limit($limit)
    {
        $this->getSqlSelect()->limit((int) $limit);
        return $this;
    }

    /**
     * @param int $offset
     * @return $this
     */
    public function offset($offset)
    {
        $this->getSqlSelect()->offset((int) $offset);
        return $this;
    }
}
