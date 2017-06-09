<?php

namespace WebinoData\Select;

use Zend\Db\Sql\Expression;

/**
 * Class ExpressionTrait
 */
trait ExpressionTrait
{
    /**
     * @param string|Expression $value
     * @return string|Expression
     */
    protected function handleExpression($value)
    {
        // detect expression
        if (is_string($value) && 0 === strpos($value, 'EXPRESSION:')) {
            return new Expression(substr($value, strlen('EXPRESSION:')));
        }
        return $value;
    }
}
