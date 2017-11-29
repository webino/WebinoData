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

use Zend\Db\Sql;

/**
 * Class Decrement
 */
class Decrement extends AbstractUpdate
{
    /**
     * @param string $identifier
     * @param string $decrement
     * @return Sql\Expression
     */
    protected function createExpression($identifier, $decrement)
    {
        return new Sql\Expression($identifier . '-' . (is_numeric($decrement) ? $decrement : 1));
    }
}
