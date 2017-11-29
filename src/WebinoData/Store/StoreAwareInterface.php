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
 * Interface StoreAwareInterface
 */
interface StoreAwareInterface
{
    /**
     * @param StoreInterface $store
     * @return $this
     */
    public function setStore(StoreInterface $store);
}
