<?php
/**
 * Webino (http://webino.sk)
 *
 * @link        https://github.com/webino/WebinoData for the canonical source repository
 * @copyright   Copyright (c) 2013-2017 Webino, s. r. o. (http://webino.sk)
 * @author      Peter Bačinský <peter@bacinsky.sk>
 * @license     BSD-3-Clause
 */

namespace WebinoData\Store;

use WebinoData\Query;

/**
 * Class QueryTrait
 */
trait QueryTrait
{
    use TraitBase;
    use Query\ToggleTrait;
    use Query\IncrementTrait;
    use Query\DecrementTrait;

    /**
     * @param string $query
     * @param null|array|\Zend\Db\Adapter\ParameterContainer $params
     * @return \Zend\Db\Adapter\Driver\ResultInterface
     */
    public function executeQuery($query, $params = null)
    {
        return $this->getAdapter()->query((string) $query)->execute($params);
    }
}
