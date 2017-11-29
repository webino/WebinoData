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

/**
 * Trait SchemaTrait
 *
 * @TODO support others platforms than MySQL only
 */
trait SchemaTrait
{
    use TraitBase;

    /**
     * @return int
     */
    public function getNextAutoIncrement()
    {
        $sql = sprintf(
            'SELECT `AUTO_INCREMENT` FROM INFORMATION_SCHEMA.TABLES '
            . 'WHERE TABLE_SCHEMA = (SELECT DATABASE()) AND TABLE_NAME = \'%s\'',
            $this->getTableName()
        );

        return (int) current($this->executeQuery($sql)->current());
    }
}
