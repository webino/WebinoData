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
 * Adds ability to add a validators to the input
 */
trait ValidableTrait
{
    /**
     * @param array $validators
     * @return self
     */
    public function setValidators(array $validators)
    {
        if (isset($this->spec['validators'])) {
            $this->spec['validators'] = array_replace_recursive($this->spec['validators'], $validators);
        } else {
            $this->spec['validators'] = $validators;
        }
        return $this;
    }
}
