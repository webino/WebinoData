<?php

namespace WebinoData\Store;

use WebinoData\DataService;

/**
 * Interface StoreAwareInterface
 */
interface StoreAwareInterface
{
    /**
     * @param DataService $store
     * @return $this
     */
    public function setStore(DataService $store);
}
