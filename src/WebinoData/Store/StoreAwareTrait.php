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
 * Class StoreAwareTrait
 */
trait StoreAwareTrait
{
    /**
     * @var StoreInterface
     */
    protected $store;

    /**
     * @return StoreInterface
     */
    public function getStore()
    {
        return $this->store;
    }

    /**
     * @param StoreInterface $store
     * @return $this
     */
    public function setStore(StoreInterface $store)
    {
        $this->store = $store;
        return $this;
    }
}
