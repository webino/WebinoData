<?php

namespace WebinoData\Select;

/**
 * Class ColumnsTrait
 */
trait ColumnsTrait
{
    /**
     * @return Columns
     */
    abstract public function getColumnsHelper();

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
