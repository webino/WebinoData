<?php

namespace WebinoData\DataPlugin;

use WebinoData\Event\DataEvent;
use Zend\EventManager\EventManager;
use Zend\Db\Adapter\AdapterInterface;
use Zend\Db\Sql\Expression as SqlExpression;

/**
 * Class Order
 */
class Order
{
    /**
     * @var AdapterInterface
     */
    protected $adapter;

    /**
     * @param AdapterInterface $adapter
     */
    public function __construct(AdapterInterface $adapter)
    {
        $this->adapter = $adapter;
    }

    /**
     * @param EventManager $eventManager
     */
    public function attach(EventManager $eventManager)
    {
        $eventManager->attach('data.exchange.pre', [$this, 'preExchange']);
        // TODO delete
        //$eventManager->attach('data.delete', array($this, 'delete'));
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

        $service = $event->getService();

        if (empty($data['order'])) {
            // as last item
            $select = $service->select(['order'])
                ->order('order DESC')
                ->limit(1);

            $lastItem = current($service->fetchWith($select));
            $data['order'] = !empty($lastItem) ? ($lastItem['order'] + 1) : 1;
        }

        // update others
        $update = $service->getSql()->update()
            ->set(['order' => new SqlExpression('`order`+1')]);

        $update->where->greaterThanOrEqualTo('order', $data['order']);
        $this->adapter->query($update->getSqlString($service->getPlatform()), 'execute');
    }

    /**
     * @param DataEvent $event
     */
    public function delete(DataEvent $event)
    {
        // todo reorder on delete
    }
}
