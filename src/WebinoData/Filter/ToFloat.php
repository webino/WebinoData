<?php

namespace WebinoData\Filter;

use Zend\Filter\AbstractFilter;

/**
 * Class ToFloat
 */
class ToFloat extends AbstractFilter
{
    /**
     * @param string $value
     * @return float
     */
    public function filter($value)
    {
        return (float) str_replace(' ', null, str_replace(',', '.', (string) $value));
    }
}
