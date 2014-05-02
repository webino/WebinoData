<?php

namespace WebinoData;

use Zend\Cache\Storage\StorageInterface as CacheInterface;

interface DataCacheAwareInterface {

    public function setCache(CacheInterface $cache);
}
