<?php

namespace WebinoData\DataPlugin;

use WebinoData\Event\DataEvent;
use Zend\EventManager\EventManager;
use Zend\Cache\Storage\Adapter\Filesystem as Cache;

/**
 * Class CacheInvalidator
 */
class CacheInvalidator extends AbstractConfigurable
{
    /**
     * @var Cache
     */
    protected $cache;

    /**
     * @var array
     */
    protected $clearByTags = [];

    /**
     * @var array
     */
    protected $clearByDateTime = [];

    /**
     * @param Cache $cache
     */
    public function __construct(Cache $cache)
    {
        $this->cache = $cache;
    }

    /**
     * @return array
     */
    protected function getClearByTags()
    {
        return $this->clearByTags;
    }

    /**
     * @param array $clearByTags
     * @return $this
     */
    public function setClearByTags(array $clearByTags)
    {
        $this->clearByTags = $clearByTags;
        return $this;
    }

    /**
     * @return array
     */
    protected function getClearByDateTime()
    {
        return $this->clearByDateTime;
    }

    /**
     * @param array $clearByDateTime
     * @return $this
     */
    public function setClearByDateTime(array $clearByDateTime)
    {
        $this->clearByDateTime = $clearByDateTime;
        return $this;
    }

    /**
     * @param EventManager $eventManager
     */
    public function attach(EventManager $eventManager)
    {
        $eventManager->attach('data.exchange.post', [$this, 'clearCache'], 100);
        $eventManager->attach('data.toggle.post', [$this, 'clearCache'], 100);
        $eventManager->attach('data.increment.post', [$this, 'clearCache'], 100);
        $eventManager->attach('data.decrement.post', [$this, 'clearCache'], 100);
        $eventManager->attach('data.delete.post', [$this, 'clearCache'], 100);
        $eventManager->attach('data.fetch.cache', [$this, 'clearCacheByDateTime'], 100);
        $eventManager->attach('data.exchange.post', [$this, 'saveNextDateTime'], 100);
    }

    /**
     * @param DataEvent $event
     */
    public function clearCache(DataEvent $event)
    {
        $event->getAffectedRows() and $this->internalClearCache($event);
    }

    /**
     * @param DataEvent $event
     * @return $this
     */
    protected function internalClearCache(DataEvent $event)
    {
        $tableName = $event->getStore()->getTableName();
        $tags = array_merge([$tableName], $this->getClearByTags());

        $store = $event->getStore();
        foreach ($store->one() as $subItem) {
            /** @var self $plugin */
            $plugin = $subItem['service']->plugin(self::class);
            $plugin and $tags = array_merge($tags, $plugin->getClearByTags());
        }

        foreach ($store->many() as $subItem) {
            /** @var self $plugin */
            $plugin = $subItem['service']->plugin(self::class);
            $plugin and $tags = array_merge($tags, $plugin->getClearByTags());
        }

        $event->setParam('clearByTags', array_unique($tags));
        $event->getStore()->getEventManager()->trigger('data.cache.clear', $event);
        return $this;
    }

    /**
     * @param DataEvent $event
     */
    public function saveNextDateTime(DataEvent $event)
    {
        $dateTimeClear = $this->getClearByDateTime();
        if (empty($dateTimeClear)) {
            return;
        }

        foreach ($dateTimeClear as $dateTimeKey) {

            $service = $event->getStore();
            $select  = $service->select([$dateTimeKey])->limit(1);

            $select->where(['`' . $dateTimeKey . '` > NOW()']);

            $cacheKey = $this->createTimeDeltaCacheKey($event, $dateTimeKey);
            $result   = current($service->fetchWith($select));

            if (empty($result)) {
                // nothing to show in the future
                $this->cache->removeItem($cacheKey);
                continue;
            }

            // save a date that we have to invalidate a cache in the future
            $this->cache->setItem($cacheKey, $result[$dateTimeKey]);
        }
    }

    /**
     * @param DataEvent $event
     */
    public function clearCacheByDateTime(DataEvent $event)
    {
        $columns = $event->getSelect()->getColumns();
        if (empty($columns['invalidateByDateTime'])) {
            return;
        }

        $cacheKey = $this->createTimeDeltaCacheKey($event, $columns['invalidateByDateTime']);
        $lastTime = $this->cache->getItem($cacheKey);

        if (empty($lastTime)) {
            // nothing to show in the future
            return;
        }

        if ((strtotime('now') >= strtotime($lastTime))) {
            $this->internalClearCache($event);
            $this->saveNextDateTime($event);
            $event->getRows()->exchangeArray([]);
        }
    }

    /**
     * @param DataEvent $event
     * @param string $dateTimeKey
     * @return string
     */
    private function createTimeDeltaCacheKey(DataEvent $event, $dateTimeKey)
    {
        return md5($event->getStore()->getTableName() . __CLASS__ . $dateTimeKey);
    }
}
