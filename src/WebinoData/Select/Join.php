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
    use PredicateTrait;

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
        $event = $this->select->getEvent();

        $event->setJoinOn($on);
        $event->setJoinColumns($columns);

        $this->getStore()->getEventManager()->trigger(DataEvent::EVENT_SELECT_JOIN, $event);

        $this->select->getSqlSelect()->join(
            $this->handleExpression($this->handleVars($name)),
            $this->handleExpression($this->handleVars($event->getJoinOn())),
            $this->handleExpression($event->getJoinColumns()),
            $type
        );

        return $this;
    }
}
