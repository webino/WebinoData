<?php

namespace WebinoData\DataPlugin;

use WebinoData\DataEvent;
use Zend\EventManager\EventManager;
use Zend\Filter\DateTimeFormatter;

class DateTimeStamp
{
    /**
     * @param EventManager $eventManager
     */
    public function attach(EventManager $eventManager)
    {
        $eventManager->attach('data.exchange.pre', array($this, 'preExchange'));
    }

    /**
     * @param DataEvent $event
     * @return void
     */
    public function preExchange(DataEvent $event)
    {
        $data = $event->getValidData();

        $dateTimeFormatter = new DateTimeFormatter();
        $dateTime = $dateTimeFormatter->filter(time());
        
        $data['updated'] = $dateTime;

        if ($event->isUpdate()) {
            return;
        }

        $data['added'] = $dateTimeFormatter->filter(time());
    }
}
