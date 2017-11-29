<?php

namespace WebinoData\Store;

use ArrayObject;
use WebinoData\Select;

/**
 * Trait SyncTrait
 */
trait SyncTrait
{
    use TraitBase;

    /**
     * Imports data
     *
     * @param array $data
     * @return $this
     */
    public function import(array $data)
    {
        $this->init();

        $dataObject = new ArrayObject($data);

        $events = $this->getEventManager();
        $event  = clone $this->getEvent();

        $event->setData($dataObject);
        $events->trigger($event::EVENT_IMPORT, $event);

        $dataObject->count()
            and $this->exchangeArray($dataObject->getArrayCopy());

        return $this;
    }

    /**
     * Exports data
     *
     * @param callable $callback
     * @param Select|null $select
     * @return $this
     */
    public function export(callable $callback, Select $select = null)
    {
        $this->init();

        $select = empty($select) ? $this->select() : $select;
        $result = $this->fetchWith($select);
        $events = $this->getEventManager();
        $event  = $this->getEvent();

        $event->setResult($result);

        foreach ($result as $row) {
            $item = new ArrayObject($row);

            $event
                ->setRow($item)
                ->setParam('callback', $callback);

            $events->trigger($event::EVENT_EXPORT, $event);
            $item->count() and $callback($item->getArrayCopy());
        }

        return $this;
    }
}
