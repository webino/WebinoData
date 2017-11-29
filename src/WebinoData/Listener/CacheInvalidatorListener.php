<?php
/**
 * Webino (http://webino.sk)
 *
 * @link        https://github.com/webino/WebinoData for the canonical source repository
 * @copyright   Copyright (c) 2013-2017 Webino, s. r. o. (http://webino.sk)
 * @author      Peter Bačinský <peter@bacinsky.sk>
 * @license     BSD-3-Clause
 */

namespace WebinoData\Listener;

use WebinoData\Event\DataEvent;
use Zend\Cache\Storage\Adapter\Filesystem as Cache;
use Zend\Cache\Storage\Adapter\Filesystem;
use Zend\EventManager\SharedEventManagerInterface;
use Zend\EventManager\SharedListenerAggregateInterface;

/**
 * Class CacheInvalidatorListener
 * @todo deprecate shared listener
 */
class CacheInvalidatorListener implements SharedListenerAggregateInterface
{
    /**
     * @var \Zend\Stdlib\CallbackHandler[]
     */
    protected $listeners = [];

    /**
     * @var array
     */
    protected $caches = [];

    /**
     * @param Cache $cache
     * @return self
     */
    public function setCache(Cache $cache)
    {
        $this->caches[] = $cache;
        return $this;
    }

    /**
     * @param SharedEventManagerInterface $events
     */
    public function attachShared(SharedEventManagerInterface $events)
    {
        $this->listeners[] = $events->attach(
            'WebinoData',
            'data.cache.clear', // TODO event constant
            [$this, 'clearCache'],
            0
        );
    }

    /**
     * @param SharedEventManagerInterface $events
     */
    public function detachShared(SharedEventManagerInterface $events)
    {
        foreach ($this->listeners as $index => $listener) {
            if ($events->detach('WebinoData', $listener)) {
                unset($this->listeners[$index]);
            }
        }
    }

    /**
     * @param DataEvent $event
     */
    public function clearCache(DataEvent $event)
    {
        $tags = $event->getParam('clearByTags');
        if (empty($tags)) {
            return;
        }

        /** @var Filesystem $cache */
        foreach ($this->caches as $cache) {
            try {
                $cache->clearByTags($tags, true);
            } catch (\Throwable $exc) {
                // TODO logger
                error_log($exc);
            }
        }
    }
}
