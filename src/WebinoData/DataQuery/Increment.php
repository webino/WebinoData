<?php

namespace WebinoData\DataQuery;

use Zend\Db\Sql\Expression as SqlExpression;

class Increment extends Toggle
{
    protected function createExpression($identifier, $increment)
    {
        return new SqlExpression($identifier . '+' . is_numeric($increment) ? $increment : 1);
    }
}
