<?php

namespace WebinoData\Select;

use Zend\Db\Sql\Select;

/**
 * Class GroupTrait
 */
trait GroupTrait
{
    use ExpressionTrait;
    use PredicateTrait;

    /**
     * @return Select
     */
    abstract public function getSqlSelect();

    /**
     * @param string $group
     * @return $this
     */
    public function group($group)
    {
        $this->getSqlSelect()->group($this->handleExpression($this->handleVars($group)));
        return $this;
    }
}
