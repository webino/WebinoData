
<?php
/**
 * Webino (http://webino.sk)
 *
 * @link        https://github.com/webino/WebinoData for the canonical source repository
 * @copyright   Copyright (c) 2012-2014 Webino, s. r. o. (http://webino.sk)
 * @author      Peter Bačinský <peter@bacinsky.sk>
 * @license     BSD-3-Clause
 */

namespace WebinoData\Config\InputFilter\Input;

/**
 * Adds ability to add a filters to the input
 */
trait FilterableTrait
{
    /**
     * @param array $filters
     * @return self
     */
    public function setFilters(array $filters)
    {
        if (isset($this->spec['filters'])) {
            $this->spec['filters'] = array_replace_recursive($this->spec['filters'], $filters);
        } else {
            $this->spec['filters'] = $filters;
        }
        
        return $this;
    }
}
