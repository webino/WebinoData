<?php
/**
 * Webino (http://webino.sk)
 *
 * @link        https://github.com/webino/WebinoData for the canonical source repository
 * @copyright   Copyright (c) 2013-2017 Webino, s. r. o. (http://webino.sk)
 * @author      Peter Bačinský <peter@bacinsky.sk>
 * @license     BSD-3-Clause
 */

namespace WebinoData\Plugin;

use WebinoData\Event\DataEvent;
use Zend\EventManager\EventManager;

/**
 * Class AutoValue
 */
class AutoValue
{
    /**
     * @param EventManager $events
     */
    public function attach(EventManager $events)
    {
        $events->attach(DataEvent::EVENT_EXCHANGE_PRE, [$this, 'preExchange'], 300);
    }

    /**
     * @param DataEvent $event
     */
    public function preExchange(DataEvent $event)
    {
        $data    = $event->getData();
        $service = $event->getStore();
        $config  = $service->getConfig();

        $autoInputs = array_filter(
            $config['input_filter'],
            function($value) {
                return !empty($value['auto_value']);
            }
        );

        foreach (array_column($autoInputs, 'auto_value', 'name') as $target => $source) {
            if (empty($data[$source])) {
                // continue on empty source data
                // because on update it may be empty
                continue;
            }

            if (is_array($data[$source])) {
                foreach ($data[$source] as $index => $value ) {

                    (!empty($data[$target][$index]) || empty($value))
                    && empty($autoInputs[$target]['auto_value_force'])
                        or $data[$target][$index] = $value;
                }

                continue;
            }

            (!empty($data[$target]) || empty($data[$source]))
            && empty($autoInputs[$target]['auto_value_force'])
                or $data[$target] = $data[$source];
        }
    }
}
