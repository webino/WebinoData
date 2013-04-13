<?php

namespace WebinoData\DataQuery;

use Zend\Db\Sql\Expression as SqlExpression;

class Increment extends Toggle
{
    protected function createExpression($identifier)
    {
        return new SqlExpression($identifier . '+1');
    }
}
