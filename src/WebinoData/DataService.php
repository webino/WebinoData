<?php

namespace WebinoData;

use WebinoData\Paginator\Adapter\WebinoDataSelect as PaginatorSelect;
use Zend\Cache\Storage\StorageInterface as CacheInterface;
use Zend\Paginator\Paginator;

// todo refactor
class DataService extends AbstractDataService
      // TODO
//    implements DataCacheAwareInterface
{
    protected $cache;
    protected $cacheTags = [];

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
        return array_merge([$this->getTableName()], $this->cacheTags);
    }

    public function setCacheTags(array $tags)
    {
        $this->cacheTags = $tags;
        return $this;
    }

    public function fetchWith(DataSelect $select, $parameters = [])
    {
        if (!$this->hasCache()) {
            return parent::fetchWith($select, $parameters);
        }

        $cache   = $this->getCache();
        $cacheId = $select->hash();
        $items   = $cache->getItem($cacheId);

        if (empty($items)) {
            // fetch items
            $items = parent::fetchWith($select, $parameters);

            $cache->setItem($cacheId, $items);
            $cache->setTags($cacheId, $this->getCacheTags());
        }

        return $items;
    }

    public function createPaginator(DataSelect $select)
    {
        $paginatorSelect = new PaginatorSelect($select, $this);
        $paginator       = new Paginator($paginatorSelect);

        !$this->hasCache() or
            $paginatorSelect
                ->setCache($this->getCache())
                ->setCacheTags($this->getCacheTags());

        return $paginator;
    }
}
