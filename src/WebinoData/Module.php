<?php
/**
 * Webino (http://webino.sk)
 *
 * @link        https://github.com/webino/WebinoData for the canonical source repository
 * @copyright   Copyright (c) 2013-2017 Webino, s. r. o. (http://webino.sk)
 * @author      Peter Bačinský <peter@bacinsky.sk>
 * @license     BSD-3-Clause
 */

namespace WebinoData;

use ArrayObject;
use Zend\Mvc\MvcEvent;

/**
 * Class Module
 */
class Module
{
    /**
     * @param MvcEvent $event
     */
    public function onBootstrap(MvcEvent $event)
    {
        $services = $event->getApplication()->getServiceManager();
        $services->get('SharedEventManager')
            ->attachAggregate($services->get(Listener\CacheInvalidatorListener::class));
    }

    /**
     * Write data into the CSV file
     *
     * @todo decouple to a service class
     *
     * @param Store $store
     * @param string $filePath
     * @param Select $select
     * @param null $callback
     * @return Module
     * @throws \InvalidArgumentException Expects filePath
     * @throws \RuntimeException Expects writable filePath
     */
    public function exportCsv(Store $store, $filePath, Select $select = null, $callback = null)
    {
        if (empty($filePath)) {
            // TODO better exception
            throw new \InvalidArgumentException('Expected `$filePath`');
        }

        if (!empty($callback) && !is_callable($callback)) {
            // TODO better exception
            throw new \InvalidArgumentException('Expected callable `$callback`');
        }

        $file = fopen($filePath, 'w');

        if (empty($file)) {
            // TODO better exception
            throw new \RuntimeException(sprintf('Can\'t open `%s` for writing', $filePath));
        }

        $header = new ArrayObject;

        $store->export(
            function (array $data) use ($file, $header, $callback) {

                $dataObject = new ArrayObject($data);
                unset($data);

                empty($callback)
                    or $callback($dataObject);

                $dataObjectArray = $dataObject->getArrayCopy();

                if (!$header->count()) {
                    // create csv header
                    foreach (array_keys($dataObjectArray) as $column) {
                        $header[] = $column;
                    }
                    fputcsv($file, $header->getArrayCopy());
                }

                // write data
                $data = [];
                foreach ($header as $headerCol) {
                    $data[$headerCol] = isset($dataObjectArray[$headerCol])
                                      ? $dataObjectArray[$headerCol]
                                      : '';
                }

                fputcsv($file, $data);
            },
            $select
        );

        fclose($file);
        return $this;
    }

    /**
     * @return array
     */
    public function getConfig()
    {
        return include __DIR__ . '/../../config/module.config.php';
    }

    /**
     * @return array
     */
    public function getServiceConfig()
    {
        return [
            'services' => [
                // todo create a service class
                'WebinoData' => $this,
            ],
        ];
    }
}
