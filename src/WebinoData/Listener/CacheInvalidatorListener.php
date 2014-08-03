<?php

namespace WebinoData\Listener;

use WebinoData\DataEvent;
use Zend\EventManager\SharedEventManagerInterface;
use Zend\EventManager\SharedListenerAggregateInterface;
use Zend\ServiceManager\ServiceManager;

/**
 *
 */
class CacheInvalidatorListener implements SharedListenerAggregateInterface
{
    /**
     * @var \Zend\Stdlib\CallbackHandler[]
     */
    protected $listeners = [];

    /**
     * @var ServiceManager
     */
    protected $services;

    /**
     * @var array
     */
    protected $caches = [];

    /**
     * @todo cache provider instead of service manager
     * @param ServiceManager $services
     */
    public function __construct(ServiceManager $services)
    {
        $this->services = $services;
    }


    /**
     * @param SharedEventManagerInterface $events
     */
    public function attachShared(SharedEventManagerInterface $events)
    {
        $this->listeners[] = $events->attach(
            'WebinoData',
            'data.cache.clear',
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
        foreach ($event->getParam('clearByTags') as $cacheName => $tags) {
            if (empty($this->caches[$cacheName])) {
                $this->caches[$cacheName] = $this->services->get($cacheName);
            }
            $this->caches[$cacheName]->clearByTags($tags);
        }
    }
}
