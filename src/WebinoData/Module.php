<?php

namespace WebinoData;

use ArrayObject;

class Module
{
    /**
     * Write data into the CSV file
     *
     * @param DataService $service
     * @param string $filePath
     * @param DataSelect $select
     * @return Module
     * @throws \InvalidArgumentException Expects filePath
     * @throws \RuntimeException Expects writable filePath
     */
    public function exportCsv(DataService $service, $filePath, DataSelect $select = null, $callback = null)
    {
        if (empty($filePath)) {
            throw new \InvalidArgumentException('Expected `$filePath`');
        }

        if (!empty($callback) && !is_callable($callback)) {
            throw new \InvalidArgumentException('Expected callable `$callback`');
        }

        $file = fopen($filePath, 'w');

        if (empty($file)) {
            throw new \RuntimeException(sprintf('Can\'t open `%s` for writing', $filePath));
        }

        $header = new ArrayObject;

        $service->export(
            function (array $data) use ($file, $header, $callback) {

                $dataObject = new ArrayObject($data);
                unset($data);

                empty($callback) or
                    $callback($dataObject);

                $dataObjectArray = $dataObject->getArrayCopy();

                if (!$header->count()) {
                    // create csv header
                    foreach (array_keys($dataObjectArray) as $column) {
                        $header[] = $column;
                    }
                    fputcsv($file, $header->getArrayCopy());
                }

                // write data
                fputcsv($file, $dataObjectArray);
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
        return array(
            'services' => array(
                'WebinoData' => $this,
            ),
        );
    }

    /**
     * Default autoloader config
     *
     * @return array
     */
    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\ClassMapAutoloader' => array(
                __DIR__ . '/autoload_classmap.php',
            ),
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__,
                ),
            ),
        );
    }
}
