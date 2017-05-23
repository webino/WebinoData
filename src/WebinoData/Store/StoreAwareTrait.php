<?php

namespace WebinoData\Store;

use WebinoData\DataService;

/**
 * Class StoreAwareTrait
 */
trait StoreAwareTrait
{
    /**
     * @var DataService
     */
    protected $store;

    /**
     * @return DataService
     */
    public function getStore()
    {
        return $this->store;
    }

    /**
     * @param DataService $store
     * @return $this
     */
    public function setStore(DataService $store)
    {
        $this->store = $store;
        return $this;
    }
}
