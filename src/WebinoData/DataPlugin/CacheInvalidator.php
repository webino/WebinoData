<?php

namespace WebinoData\DataPlugin;

use WebinoData\DataEvent;
use Zend\EventManager\EventManager;

/**
 *
 */
class CacheInvalidator extends AbstractConfigurable
{
    /**
     * @var array
     */
    protected $clearByTags = [];

    /**
     * @return array
     */
    public function getClearByTags()
    {
        return $this->clearByTags;
    }

    /**
     * @param array $clearByTags
     * @return self
     */
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
        $eventManager->attach('data.exchange.post', [$this, 'clearCache'], 100);
        $eventManager->attach('data.toggle.post', [$this, 'clearCache'], 100);
        $eventManager->attach('data.increment.post', [$this, 'clearCache'], 100);
        $eventManager->attach('data.decrement.post', [$this, 'clearCache'], 100);
        $eventManager->attach('data.delete.post', [$this, 'clearCache'], 100);
    }

    /**
     * @param DataEvent $event
     */
    public function clearCache(DataEvent $event)
    {
        if (!$event->getAffectedRows()) {
            return;
        }

        $event->setparam('clearByTags', $this->getClearByTags());
        $event->getService()->getEventManager()->trigger('data.cache.clear', $event);
    }
}
