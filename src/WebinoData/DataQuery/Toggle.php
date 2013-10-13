<?php

namespace WebinoData\DataQuery;

use Zend\Db\Adapter\Platform\PlatformInterface;
use Zend\Db\Sql\Expression as SqlExpression;
use Zend\Db\Sql\Update as SqlUpdate;

class Toggle extends AbstractDataQuery
{
    protected $column;

    public function __construct($column, SqlUpdate $sql, PlatformInterface $platform)
    {
        $this->column = $column;

        parent::__construct($sql, $platform);
    }

    public function toString()
    {
        return $this->__toString();
    }

    public function __toString()
    {
        $columns = is_array($this->column) ? $this->column : array($this->column => 1);
        $set     = array();

        foreach ($columns as $column => $value) {

            $column       = !is_numeric($column) ? $column : $value;
            $identifier   = $this->platform->quoteIdentifier($column);
            $set[$column] = $this->createExpression($identifier, $value);
        }

        $this->sql->set($set);

        return $this->sql->getSqlString($this->platform);
    }

    protected function createExpression($identifier, $value)
    {
        return new SqlExpression('NOT ' . $identifier);
    }
}
