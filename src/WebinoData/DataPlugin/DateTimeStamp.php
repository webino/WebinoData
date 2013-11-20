<?php

namespace WebinoData\DataPlugin;

use ArrayAccess;
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
        $eventManager->attach('data.export', array($this, 'export'));
    }

    /**
     * @param DataEvent $event
     * @return void
     */
    public function preExchange(DataEvent $event)
    {
        $data = $event->getValidData();

        // resolve inputs
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

        $dateTimeFormatter = new DateTimeFormatter();
        $dateTime = $dateTimeFormatter->filter('now');

        empty($inputs['updated']) or
            $data['updated'] = $dateTime;

        if ($event->isUpdate()) {
            return;
        }

        empty($inputs['added']) or
            $data['added'] = $dateTime;
    }

    public function export(DataEvent $event)
    {
        $this->unsetTimeStamps($event->getRow());
    }

    public function import(DataEvent $event)
    {
        $this->unsetTimeStamps($event->getData());
    }

    public function unsetTimeStamps(ArrayAccess $data)
    {
        // don't want to synchronize this
        if (isset($data['added'])) {
            unset($data['added']);
        }

        if (isset($data['updated'])) {
            unset($data['updated']);
        }
    }
}
