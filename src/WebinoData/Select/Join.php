<?php
/**
 * Webino (http://webino.sk)
 *
 * @link        https://github.com/webino/WebinoData for the canonical source repository
 * @copyright   Copyright (c) 2013-2017 Webino, s. r. o. (http://webino.sk)
 * @author      Peter Bačinský <peter@bacinsky.sk>
 * @license     BSD-3-Clause
 */

namespace WebinoData\Select;

use Zend\Db\Sql\Select;

/**
 * Class Join
 */
class Join extends AbstractHelper
{
    use ExpressionTrait;
    use PredicateTrait;

    /**
     * @return \WebinoData\Store\StoreInterface
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

        $this->getStore()->getEventManager()->trigger($event::EVENT_SELECT_JOIN, $event);

        $this->select->getSqlSelect()->join(
            $name,
            $this->handleExpression($this->handleVars($event->getJoinOn())),
            $this->handleExpression($event->getJoinColumns()),
            $type
        );

        return $this;
    }
}
