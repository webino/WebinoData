<?php
/**
 * Webino (http://webino.sk)
 *
 * @link        https://github.com/webino/WebinoData for the canonical source repository
 * @copyright   Copyright (c) 2013-2017 Webino, s. r. o. (http://webino.sk)
 * @author      Peter Bačinský <peter@bacinsky.sk>
 * @license     BSD-3-Clause
 */

namespace WebinoData\Store;

use WebinoData\Event\DataEvent;
use Zend\EventManager\EventManager;
use Zend\EventManager\EventManagerInterface;

/**
 * Trait EventsTrait
 * @TODO deprecate shared event manager
 */
trait EventsTrait
{
    use TraitBase;

    /**
     * @var DataEvent
     */
    protected $event;

    /**
     * @var EventManagerInterface
     */
    protected $eventManager;

    /**
     * {@inheritdoc}
     */
    public function getEvent()
    {
        (null === $this->event) and $this->createEvent();
        return $this->event;
    }

    /**
     * @param DataEvent $event
     * @return $this
     */
    public function setEvent(DataEvent $event)
    {
        $this->event = $event;
        return $this;
    }

    /**
     * @return DataEvent
     */
    protected function createEvent()
    {
        $event = new DataEvent;
        /** @var StoreInterface $this */
        $event->setStore($this);
        $this->setEvent($event);
        return $event;
    }

    /**
     * @return EventManagerInterface
     */
    public function getEventManager()
    {
        if (null === $this->eventManager) {
            $this->setEventManager(new EventManager);
        }
        return $this->eventManager;
    }

    /**
     * @param EventManagerInterface $eventManager
     * @return $this
     */
    public function setEventManager(EventManagerInterface $eventManager)
    {
        $eventManager->setIdentifiers([
            __CLASS__,
            'WebinoData',
            'WebinoData[' . $this->getTableName() . ']',
            // todo deprecated
            $this->getTableName()
        ]);

        $this->eventManager = $eventManager;
        return $this;
    }
}
