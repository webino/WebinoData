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
        $eventManager->attach('data.exchange.invalid', [$this, 'invalidExchange']);
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
                return !empty($value['auto_value']);
            }
        );

        $autoInputs = array_column($autoInputs, 'auto_value');
        foreach ($autoInputs as $target => $source) {
            if (is_array($data[$source])) {

                foreach ($data[$source] as $index => $value ) {

                    !empty($data[$target][$index]) || empty($value)
                        or $data[$target] = $data[$source];
                }

                continue;
            }

            !empty($data[$target]) || empty($data[$source])
                or $data[$target] = $data[$source];
        }
    }
}
