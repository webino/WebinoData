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
        $identifier = $this->platform->quoteIdentifier($this->column);

        $this->sql->set(
            array(
                $this->column => $this->createExpression($identifier),
            )
        );

        return $this->sql->getSqlString($this->platform);
    }

    protected function createExpression($identifier)
    {
        return new SqlExpression('NOT ' . $identifier);
    }
}
