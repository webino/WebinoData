<?php

namespace WebinoData\Select;

use WebinoData\Event\DataEvent;
use Zend\Db\Sql\Select;

/**
 * Class Join
 */
class Join extends AbstractHelper
{
    use ExpressionTrait;

    /**
     * @return \WebinoData\AbstractDataService
     */
    public function getStore()
    {
        return $this->select->getStore();
    }

    /**
     * @param string|array $name
     * @param string $on
     * @param string|array $columns
     * @param string $type
     * @return $this
     */
    public function join($name, $on, $columns = Select::SQL_STAR, $type = Select::JOIN_INNER)
    {
        if (is_array($columns)) {
            array_walk($columns, function (&$value) {
                $value = $this->handleExpression($value);
            });
        }

        $event = $this->select->getEvent();
        $event->setParam('on', $on);

        $this->getStore()->getEventManager()
            ->trigger(DataEvent::EVENT_SELECT_JOIN, $event);

        $this->select->getSqlSelect()
            ->join($name, $this->handleExpression($event->getParam('on')), $columns, $type);

        return $this;
    }
}
