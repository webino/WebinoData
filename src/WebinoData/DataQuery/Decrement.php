<?php

namespace WebinoData\DataQuery;

use Zend\Db\Sql\Expression as SqlExpression;

class Decrement extends Toggle
{
    protected function createExpression($identifier)
    {
        return new SqlExpression($identifier . '-1');
    }
}
