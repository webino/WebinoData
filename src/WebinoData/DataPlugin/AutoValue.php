<?php

namespace WebinoData\DataPlugin;

use WebinoData\DataEvent;
use Zend\EventManager\EventManager;

class AutoValue
{
    /**
     * @param EventManager $eventManager
     */
    public function attach(EventManager $eventManager)
    {
        $eventManager->attach('data.exchange.invalid', array($this, 'invalidExchange'));
    }

    /**
     * @param DataEvent $event
     * @return void
     */
    public function invalidExchange(DataEvent $event)
    {
        $data    = $event->getData();
        $service = $event->getService();
        $config  = $service->getConfig();

        $autoInputs = array_filter(
            $config['input_filter'],
            function($value) {
                if (!empty($value['auto_value'])) {
                    return true;
                }
            }
        );

        // todo PHP 5.5 array_column
        $autoInputs = array_map(
            function($value) {
                return $value['auto_value'];
            },
            $autoInputs
        );

        foreach ($autoInputs as $target => $source) {

            if (is_array($data[$source])) {

                foreach ($data[$source] as $index => $value ) {

                    !empty($data[$target][$index]) || empty($value) or
                        $data[$target] = $data[$source];
                }

                continue;
            }

            !empty($data[$target]) || empty($data[$source]) or
                $data[$target] = $data[$source];
        }
    }
}
