<?php

namespace WebinoData\DataPlugin;

use WebinoData\Event\DataEvent;
use Zend\EventManager\EventManager;

/**
 * Class AutoValue
 */
class AutoValue
{
    /**
     * @param EventManager $eventManager
     */
    public function attach(EventManager $eventManager)
    {
        $eventManager->attach('data.exchange.pre', [$this, 'preExchange'], 300);
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
            if (is_array($data[$source])) {

                foreach ($data[$source] as $index => $value ) {

                    (!empty($data[$target][$index]) || empty($value))
                    && empty($autoInputs[$target]['auto_value_force'])
                        or $data[$target] = $data[$source];
                }

                continue;
            }

            (!empty($data[$target]) || empty($data[$source]))
            && empty($autoInputs[$target]['auto_value_force'])
                or $data[$target] = $data[$source];
        }
    }
}
