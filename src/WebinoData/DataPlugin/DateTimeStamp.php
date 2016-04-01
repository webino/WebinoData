<?php

namespace WebinoData\DataPlugin;

use ArrayAccess;
use WebinoData\Event\DataEvent;
use Zend\EventManager\EventManager;
use Zend\Filter\DateTimeFormatter;

/**
 * Class DateTimeStamp
 */
class DateTimeStamp
{
    /**
     * @param EventManager $eventManager
     */
    public function attach(EventManager $eventManager)
    {
        $eventManager->attach('data.exchange.pre', [$this, 'preExchange']);
        $eventManager->attach('data.export', [$this, 'export']);
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

        $dateTimeFormatter = new DateTimeFormatter;
        $dateTime = $dateTimeFormatter->filter('now');
        $inputs = array_column(array_filter($config['input_filter']), 'name');

        empty($inputs['updated'])
            or $data['updated'] = $dateTime;

        if ($event->isUpdate()) {
            return;
        }

        (empty($inputs['added'])
            or !empty($data['added']))
            or $data['added'] = $dateTime;
    }

    /**
     * @param DataEvent $event
     */
    public function export(DataEvent $event)
    {
        $this->unsetTimeStamps($event->getRow());
    }

    /**
     * @param DataEvent $event
     */
    public function import(DataEvent $event)
    {
        $this->unsetTimeStamps($event->getData());
    }

    /**
     * @param ArrayAccess $data
     */
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
