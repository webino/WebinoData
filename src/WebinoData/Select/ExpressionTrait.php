<?php

namespace WebinoData\Select;

use Zend\Db\Sql\Expression;

/**
 * Class ExpressionTrait
 */
trait ExpressionTrait
{
    /**
     * @param string|array|Expression $value
     * @return string|array|Expression
     */
    protected function handleExpression($value)
    {
        if (is_array($value)) {
            array_walk($value, function (&$value) {
                $value = $this->handleExpression($value);
            });
            return $value;
        }

        // detect expression
        if (is_string($value) && 0 === strpos($value, 'EXPRESSION:')) {
            return new Expression(substr($value, strlen('EXPRESSION:')));
        }
        return $value;
    }
}
