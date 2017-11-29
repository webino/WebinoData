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

/**
 * Class ColumnsTrait
 */
trait ColumnsTrait
{
    /**
     * @var Columns
     */
    protected $columnsHelper;

    /**
     * @return Columns
     */
    public function getColumnsHelper()
    {
        if (null === $this->columnsHelper) {
            $this->columnsHelper = new Columns($this);
        }
        return $this->columnsHelper;
    }

    /**
     * @param Columns $columnsHelper
     * @return $this
     */
    public function setColumnsHelper(Columns $columnsHelper)
    {
        $this->columnsHelper = $columnsHelper;
        return $this;
    }

    /**
     * @param array $columns
     * @return $this
     */
    public function columns(array $columns)
    {
        $this->getColumnsHelper()->setColumns($columns);
        return $this;
    }

    /**
     * @param array $columns
     * @return $this
     */
    public function addColumns(array $columns)
    {
        $this->getColumnsHelper()->addColumns($columns);
        return $this;
    }

    /**
     * @param string $name
     * @param string|array $value
     * @return $this
     */
    public function addColumn($name, $value)
    {
        $this->getColumnsHelper()->addColumn($name, $value);
        return $this;
    }

    /**
     * @param string $name
     * @return $this
     */
    public function removeColumn($name)
    {
        $this->getColumnsHelper()->removeColumn($name);
        return $this;
    }
}
