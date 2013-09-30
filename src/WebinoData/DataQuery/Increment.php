<?php

namespace WebinoData\DataQuery;

use Zend\Db\Sql\Expression as SqlExpression;

class Increment extends Toggle
{
    protected $increment = 1 ;

    public function setIncrement($increment)
    {
        $this->increment = $increment;
        return $this;
    }

    protected function createExpression($identifier)
    {
        return new SqlExpression($identifier . '+' . $this->increment);
    }
}
