<?php

namespace WebinoData;

use ArrayObject;
use WebinoData\Paginator\Adapter\WebinoDataSelect as PaginatorSelect;
use Zend\Cache\Storage\Adapter\Filesystem as Cache;
use Zend\Paginator\Paginator;

// todo refactor
class DataService extends AbstractDataService
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

    public function setCache(Cache $cache)
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

        $this->init();

        $cache   = $this->getCache();
        $cacheId = $select->hash();
        $items   = new ArrayObject((array) $cache->getItem($cacheId));
        $events  = $this->getEventManager();
        $event   = clone $this->getEvent();

        $event->setSelect($select);
        $event->setRows($items);
        $events->trigger(DataEvent::EVENT_FETCH_CACHE, $event);

        if (!$items->count()) {
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
