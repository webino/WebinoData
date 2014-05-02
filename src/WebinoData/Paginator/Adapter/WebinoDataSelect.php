<?php

namespace WebinoData\Paginator\Adapter;

use WebinoData\DataSelect;
use Zend\Cache\Storage\StorageInterface as CacheInterface;

class WebinoDataSelect extends AbstractWebinoDataSelect
{
    protected $cache;
    protected $cacheId;
    protected $cacheTags = [];

    public function __construct(DataSelect $select, $service)
    {
        parent::__construct($select, $service);
        $this->cacheId = $select->hash();
    }

    public function hasCache()
    {
        return null !== $this->cache;
    }

    protected function getCache()
    {
        return $this->cache;
    }

    public function setCache(CacheInterface $cache)
    {
        $this->cache = $cache;
        return $this;
    }

    public function getCacheTags()
    {
        return $this->cacheTags;
    }

    public function setCacheTags(array $tags)
    {
        $this->cacheTags = $tags;
        return $this;
    }

    public function count()
    {
        if (!$this->hasCache()) {
            return parent::count();
        }

        $cache   = $this->getCache();
        $cacheId = md5($this->cacheId . '_count');
        $count   = $cache->getItem($cacheId);

        if (null === $count) {
            // fetch count
            $count = parent::count();

            $cache->setItem($cacheId, $count);
            $cache->setTags($cacheId, $this->getCacheTags());
        }

        return $count;
    }
}
