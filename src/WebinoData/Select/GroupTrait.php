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
 * Class GroupTrait
 */
trait GroupTrait
{
    use ExpressionTrait;
    use PredicateTrait;

    /**
     * @return Select
     */
    abstract public function getSqlSelect();

    /**
     * @param string $group
     * @return $this
     */
    public function group($group)
    {
        $this->getSqlSelect()->group($this->handleExpression($this->handleVars($group)));
        return $this;
    }
}
