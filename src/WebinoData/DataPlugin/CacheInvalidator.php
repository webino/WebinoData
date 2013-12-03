<?php

namespace WebinoData\DataPlugin;

use WebinoData\DataEvent;
use Zend\EventManager\EventManager;

class CacheInvalidator extends AbstractConfigurable
{
    /**
     * @var array
     */
    protected $clearByTags = array();

    public function getClearByTags()
    {
        return $this->clearByTags;
    }

    public function setClearByTags(array $clearByTags)
    {
        $this->clearByTags = $clearByTags;
        return $this;
    }

    /**
     * @param EventManager $eventManager
     */
    public function attach(EventManager $eventManager)
    {
        $eventManager->attach('data.exchange.post', array($this, 'clearCache'), 100);
        $eventManager->attach('data.toggle', array($this, 'clearCache'), 100);
        $eventManager->attach('data.increment', array($this, 'clearCache'), 100);
        $eventManager->attach('data.decrement', array($this, 'clearCache'), 100);
        $eventManager->attach('data.delete', array($this, 'clearCache'), 100);
    }

    public function clearCache(DataEvent $event)
    {
        // todo injection
        $services = $event->getService()->getServiceManager();

        foreach ($this->getClearByTags() as $cacheName => $tags) {

            $services->get($cacheName)
                ->clearByTags($tags);
        }
    }
}
