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
use Zend\Db\Sql\Expression;

/**
 * Class Order
 */
class Order implements OrderInterface
{
    /**
     * @param EventManager $events
     */
    public function attach(EventManager $events)
    {
        $events->attach(DataEvent::EVENT_EXCHANGE_PRE, [$this, 'preExchange']);
        //$events->attach('data.delete', [$this, 'delete']); // TODO delete
    }

    /**
     * @param DataEvent $event
     * @return void
     */
    public function preExchange(DataEvent $event)
    {
        $data = $event->getValidData();

        if (!$data->offsetExists('order')) {
            // return early for no order
            return;
        }

        $store = $event->getStore();

        if (empty($data['order'])) {
            // as last item
            $select = $store->select(['order'])
                ->order('order DESC')
                ->limit(1);

            $lastItem = current($store->fetchWith($select));
            $data['order'] = !empty($lastItem) ? ($lastItem['order'] + 1) : 1;
        }

        // update others
        $update = $store->getSql()->update()
            ->set(['order' => new Expression('`order`+1')]);

        $update->where->greaterThanOrEqualTo('order', $data['order']);
        $store->executeQuery($update->getSqlString($store->getPlatform()));
    }

    /**
     * @TODO
     * @param DataEvent $event
     */
    public function delete(DataEvent $event)
    {
        // todo reorder on delete
    }
}
