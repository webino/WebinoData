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

use Zend\Db\Adapter\Platform\PlatformInterface;
use Zend\Db\Sql;

/**
 * Class AbstractQuery
 */
abstract class AbstractQuery
{
    /**
     * @var Sql\AbstractPreparableSql
     */
    private $sql;

    /**
     * @var PlatformInterface
     */
    protected $platform;

    /**
     * @param Sql\AbstractPreparableSql $sql
     * @param PlatformInterface $platform
     */
    public function __construct(Sql\AbstractPreparableSql $sql, PlatformInterface $platform)
    {
        $this->sql = $sql;
        $this->platform = $platform;
    }

    /**
     * @return Sql\AbstractPreparableSql
     */
    public function getSql()
    {
        return $this->sql;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return $this->sql->getSqlString($this->platform);
    }
}
