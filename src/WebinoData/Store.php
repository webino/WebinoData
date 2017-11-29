<?php
/**
 * Webino (http://webino.sk)
 *
 * @link        https://github.com/webino/WebinoData for the canonical source repository
 * @copyright   Copyright (c) 2013-2017 Webino, s. r. o. (http://webino.sk)
 * @author      Peter Bačinský <peter@bacinsky.sk>
 * @license     BSD-3-Clause
 */

namespace WebinoData;

use ArrayObject;
use Zend\Cache\Storage\Adapter\Filesystem as Cache;

/**
 * Class DataService
 */
class Store extends Store\AbstractStore
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
     * @param array $tags
     * @return $this
     */
    public function setCacheTags(array $tags)
    {
        $this->cacheTags = $tags;
        return $this;
    }

    /**
     * @TODO
     * @return array
     */
    public function getCacheTagsForAll()
    {
        $tags = [];
        $this->mergeCacheTags($this->one(), $tags);
        $this->mergeCacheTags($this->many(), $tags);
        return array_unique($tags);
    }

    /**
     * @param Select $select
     * @param array $parameters
     * @return array|ArrayObject
     */
    public function fetchWith(Select $select, $parameters = [])
    {
        $select->setHash($parameters);

        if (!$this->hasCache()) {
            return parent::fetchWith($select, $parameters);
        }

        $this->init();

        $cache   = $this->getCache();
        $cacheId = $select->getHash();
        $items   = new ArrayObject((array) $cache->getItem($cacheId));
        $events  = $this->getEventManager();
        $event   = clone $this->getEvent();

        $event->setSelect($select);
        $event->setRows($items);
        $events->trigger($event::EVENT_FETCH_CACHE, $event);

        if (!$items->count()) {
            $items = parent::fetchWith($select, $parameters);
            $cache->setItem($cacheId, $items);
            $cache->setTags($cacheId, $this->getCacheTags());
        }

        return $items;
    }

    /**
     * @param Select $select
     * @return Paginator
     */
    public function createPaginator(Select $select)
    {
        $paginator = parent::createPaginator($select);

        $this->hasCache()
            and $paginator->getSelect()
                ->setCache($this->getCache())
                ->setCacheTags($this->getCacheTags());

        return $paginator;
    }

    /**
     * @param array $items
     * @param array $cacheTags
     */
    private function mergeCacheTags(array $items, array &$cacheTags)
    {
        foreach ($items as $item) {
            if (empty($item['service'])) {
                continue;
            }

            /** @var self $store */
            $store     = $item['service']; // TODO use store instead of service word
            $cacheTags = array_merge($cacheTags, $store->getCacheTags());
        }
    }
}
