<?php

namespace WebinoData\DataQuery;

use Zend\Db\Sql\Expression as SqlExpression;

class Decrement extends Toggle
{
    protected $decrement = 1;

    public function setDecrement($decrement)
    {
        $this->decrement = $decrement;
        return $this;
    }

    protected function createExpression($identifier)
    {
        return new SqlExpression($identifier . '-' . $this->decrement);
    }
}
