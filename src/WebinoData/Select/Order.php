<?php

namespace WebinoData\Select;

use Zend\Db\Sql\Expression;

/**
 * Class Order
 */
class Order extends AbstractHelper
{
    use PredicateTrait;

    /**
     * @return \WebinoData\AbstractDataService
     */
    public function getStore()
    {
        return $this->select->getStore();
    }

    /**
     * @param string|array $order
     * @return $this
     */
    public function order($order)
    {
        $platform = $this->getStore()->getPlatform();
        $cols     = $this->select->getColumns();
        $trick    = 'CAST(%s as UNSIGNED)';

        $_order = [];
        $parts  = is_array($order) ? $order : explode(',', $order);

        foreach ($parts as $value) {
            $value = trim($value);

            // handle function expression
            if (strpos($value, '(')) {
                $_order[] = $value;
                continue;
            }

            // handle column without order type
            if (false === strpos($value, ' ')) {
                $key = $platform->quoteIdentifierChain(explode('.', $value));
                $_order[] = sprintf($trick, $key);
                $_order[] = $key;
                continue;
            }

            list($col, $type) = explode(' ', $value);

            // handle expression column
            if (!empty($cols[$col]) && $cols[$col] instanceof Expression) {
                /** @var Expression $expr */
                $expr = $cols[$col];
                if (strpos($expr->getExpression(), '(')) {
                    $_order[] = $platform->quoteIdentifierChain(explode('.', $col));
                    continue;
                }
            }

            // natural sorting workaround
            $key = $platform->quoteIdentifierChain(explode('.', $col));
            $_order[] = sprintf($trick, $key) . ' ' . $type;
            $_order[] = $key . ' ' . $type;
        }

        $order = join(', ', $_order);
        $this->replaceVars($order);
        $this->select->getSqlSelect()->order(new Expression($order));

        return $this;
    }
}
