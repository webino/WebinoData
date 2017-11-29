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

use WebinoData\Select;
use Zend\Db\Sql\Select as SqlSelect;

/**
 * Class CombineTrait
 */
trait CombineTrait
{
    /**
     * @return SqlSelect
     */
    abstract public function getSqlSelect();

    /**
     * Combine select
     *
     * @see CombineTrait::union() Union select
     *
     * @param Select $select
     * @param string $type
     * @param string $modifier
     * @return $this
     */
    public function combine(Select $select, $type = SqlSelect::COMBINE_UNION, $modifier = '')
    {
        $this->getSqlSelect()->combine($select->getSqlSelect(), $type, $modifier);
        return $this;
    }

    /**
     * Union select
     *
     * @param Select $select
     * @return $this
     */
    public function union(Select $select)
    {
        $this->combine($select, SqlSelect::COMBINE_UNION, '');
        return $this;
    }
}
