<?php

namespace WebinoData\DataQuery;

use Zend\Db\Sql\Expression as SqlExpression;

class Decrement extends Toggle
{
    protected function createExpression($identifier, $decrement)
    {
        return new SqlExpression($identifier . '-' . $decrement);
    }
}
