<?php
/**
 * Webino (http://webino.sk/)
 *
 * @link        https://github.com/webino/WebinoData/ for the canonical source repository
 * @copyright   Copyright (c) 2013 Webino, s. r. o. (http://webino.sk/)
 * @license     New BSD License
 */

namespace Application\Controller;

use Zend\Mvc\Controller\AbstractActionController;

/**
 * WebinoData test application controller
 */
class IndexController extends AbstractActionController
{
    /**
     * Use case examples
     *
     * - insert (get insert id)
     * - update
     * - delete
     * - toggle/increment/decrement
     * - select
     * - limit/offset/order
     * - related data/association/composition (fetch/save)
     * - tree
     * - search
     * - bind form
     * - pagination
     *
     * plugins:
     * - language
     * - orderable
     * - orderable tree
     * - datetime
     * - datetime range
     * - cache
     *
     * @return array
     */
    public function indexAction()
    {
        $dataService = $this->getServiceLocator()->get('ExampleDataService');

        // 1) insert
        $row = array(
            'text' => 'pokus ' . rand(),
        );

        $dataService->exchangeArray($row);

        // last id
        $dataService->getLastInsertValue();

        // 2) update
        $row = array(
            'id' => '1',
            'text' => 'pokus ' . rand(),
        );

        $dataService->exchangeArray($row);

        // 3) TODO delete example

        // 4) toggle/increment/decrement
        $where = array('id' => '1');
        $dataService->toggle('toggle', $where);

        $where = array('id' => '2');
        $dataService->increment('counter', $where);

        $where = array('id' => '1');
        $dataService->decrement('counter', $where);

        // 5) select
        $params = array(':param' => 'value');
        $list   = $dataService->fetch('all', $params);

        // 6) limit/offset/order
        $select = $dataService
                    ->configSelect('limited')
                    ->limit(10)
                    ->offset(0)
                    ->order(array('counter ASC', 'id DESC'));

        $list = $dataService->fetchWith($select);

        // 7) data structure
        $mainDataService = $this->getServiceLocator()->get('MainDataService');

        $mainData = array(
            'name' => 'main data test',
            'sub' => array(
                'value' => 'sub data test value',
            ),
            'sub2' => array(
                'value' => 'sub2 data test value',
            ),
            'sub_items' => array(
                array('value' => 'sub in the list test value'),
                array('value' => 'sub in the list test value2'),
            ),
        );

        $mainDataService->exchangeArray($mainData);

        $select = $mainDataService->select();

        $select->columns(
            array(
                'name',
                'sub'       => $mainDataService->one('sub')->select(),
                'sub2'      => $mainDataService->one('sub2')->select(),
                'sub_items' => $mainDataService->many('sub_items')->select(),
            )
        );

        $data = $mainDataService->fetchWith($select);

        return array(
            'head' => array(
                'id', 'text', 'toggle', 'counter',
            ),
            'list' => $list,
            'data' => $data,
        );
    }

    /**
     *
     */
    public function saveAction()
    {
        $this->redirect()->toUrl($this->request->getBaseUrl());
    }
}
