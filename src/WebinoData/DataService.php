<?php

namespace WebinoData;

use ArrayObject;
use WebinoData\Paginator\Adapter\WebinoDataSelect as PaginatorSelect;
use Zend\Cache\Storage\Adapter\Filesystem as Cache;
use Zend\Paginator\Paginator;

/**
 * Class DataService
 * @todo refactor
 */
class DataService extends AbstractDataService
{
    /**
     * @var Cache
     */
    protected $cache;

    /**
     * @var array
     */
    protected $cacheTags = [];

    /**
     * @return bool
     */
    public function hasCache()
    {
        return null !== $this->cache;
    }

    /**
     * @return Cache|null
     */
    protected function getCache()
    {
        return $this->cache;
    }

    /**
     * @param Cache|null $cache
     * @return $this
     */
    public function setCache(Cache $cache = null)
    {
        $this->cache = $cache;
        return $this;
    }

    /**
     * @return array
     */
    public function getCacheTags()
    {
        return array_merge([$this->getTableName()], $this->cacheTags);
    }

    /**
     * @return array
     */
    public function getCacheTagsForAll()
    {
        $cacheTags = [];
        foreach ($this->one() as $one) {
            /** @var self $store */
            $store = $one['service'];
            $cacheTags = array_merge($cacheTags, $store->getCacheTags());
        }

        foreach ($this->many() as $many) {
            /** @var self $store */
            $store = $many['service'];
            $cacheTags = array_merge($cacheTags, $store->getCacheTags());
        }

        return array_unique($cacheTags);
    }

    /**
     * @param array $tags
     * @return $this
     */
    public function setCacheTags(array $tags)
    {
        $this->cacheTags = $tags;
        return $this;
    }

    /**
     * @param DataSelect $select
     * @param array $parameters
     * @return array|ArrayObject
     */
    public function fetchWith(DataSelect $select, $parameters = [])
    {
        $select->setHash($parameters);

        if (!$this->hasCache()) {
            return parent::fetchWith($select, $parameters);
        }

        $this->init();

        $cache   = $this->getCache();
        $cacheId = $select->hash();
        $items   = new ArrayObject((array) $cache->getItem($cacheId));
        $events  = $this->getEventManager();
        $event   = clone $this->getEvent();

        $event->setSelect($select);
        $event->setRows($items);
        $events->trigger(Event\DataEvent::EVENT_FETCH_CACHE, $event);

        if (!$items->count()) {
            $items = parent::fetchWith($select, $parameters);
            $cache->setItem($cacheId, $items);
            $cache->setTags($cacheId, $this->getCacheTags());
        }

        return $items;
    }

    /**
     * @param DataSelect $select
     * @return Paginator
     */
    public function createPaginator(DataSelect $select)
    {
        $paginatorSelect = new PaginatorSelect($select, $this);
        $paginator       = new Paginator($paginatorSelect);

        $this->hasCache()
            and $paginatorSelect
                ->setCache($this->getCache())
                ->setCacheTags($this->getCacheTags());

        return $paginator;
    }
}
