<?php
/**
 * Webino (http://webino.sk)
 *
 * @link        https://github.com/webino/WebinoData for the canonical source repository
 * @copyright   Copyright (c) 2013-2017 Webino, s. r. o. (http://webino.sk)
 * @author      Peter Bačinský <peter@bacinsky.sk>
 * @license     BSD-3-Clause
 */

namespace WebinoData\Store;

use WebinoData\Select;

/**
 * Trait SelectTrait
 */
trait SelectTrait
{
    use TraitBase;

    /**
     * Returns store data select
     *
     * @param array $columns
     * @return Select
     */
    public function select($columns = [])
    {
        $this->init();

        /** @var StoreInterface $this */
        $select = new Select($this, $this->getSql()->select());
        $events = $this->getEventManager();
        $event  = $this->createEvent();

        $event->setSelect($select);
        $events->trigger($event::EVENT_SELECT, $event);
        empty($columns) or $select->columns($columns);

        return $select;
    }

    /**
     * Configures multiple selects
     *
     * @param array ...$selectNames
     * @return Select
     */
    public function configSelect(...$selectNames)
    {
        $firstArg    = current($selectNames);
        $selectNames = is_array($firstArg) ? $firstArg : $selectNames;
        $select      = $this->select();
        $config      = $this->getConfig();

        $selectConfig = [];
        foreach ($selectNames as $selectName) {

            if (!is_string($selectName)) {
                continue;
            }
            if (!isset($config['select'][$selectName])) {
                // allow empty select config
                continue;
            }

            $selectConfig = array_replace_recursive(
                $selectConfig,
                $config['select'][$selectName]
            );
        }

        $select->configure($selectConfig);
        return $select;
    }

    /**
     * Configures select set
     *
     * @param string $name
     * @return Select
     */
    public function configSelects($name)
    {
        $select = $this->select();
        $config = $this->getConfig();

        // TODO use selects key instead of selectset
        return !empty($config['selectset'][$name]) ? $this->configSelect($config['selectset'][$name]) : $select;
    }

    /**
     * @TODO remove, deprecated
     * @deprecated use configSelects()
     * @param string $name
     * @return Select
     */
    public function configSelectset($name)
    {
        return $this->configSelects($name);
    }
}
