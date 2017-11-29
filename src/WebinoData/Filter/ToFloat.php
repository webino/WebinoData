<?php
/**
 * Webino (http://webino.sk)
 *
 * @link        https://github.com/webino/WebinoData for the canonical source repository
 * @copyright   Copyright (c) 2013-2017 Webino, s. r. o. (http://webino.sk)
 * @author      Peter Bačinský <peter@bacinsky.sk>
 * @license     BSD-3-Clause
 */

namespace WebinoData\Filter;

use Zend\Filter\AbstractFilter;

/**
 * Class ToFloat
 */
class ToFloat extends AbstractFilter
{
    /**
     * Anything to float
     *
     * @param string $value
     * @return float
     */
    public function filter($value)
    {
        return (float) str_replace(' ', null, str_replace(',', '.', (string) $value));
    }
}
