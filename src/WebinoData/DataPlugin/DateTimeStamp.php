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

        $service = $event->getService();
        $config  = $service->getConfig();
        unset($config['input_filter']['type']);

        // todo PHP 5.5 array_column
        $inputs = array_flip(
            array_map(
                function($value) {
                    return $value['name'];
                },
                $config['input_filter']
            )
        );

        if (empty($inputs['added'])) {
            // added is optional
            return;
        }

        $data['added'] = $dateTime;
    }
}
