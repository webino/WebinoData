<?php
/**
 * Webino (http://webino.sk)
 *
 * @link        https://github.com/webino/WebinoData for the canonical source repository
 * @copyright   Copyright (c) 2012-2016 Webino, s. r. o. (http://webino.sk)
 * @author      Peter Bačinský <peter@bacinsky.sk>
 * @license     BSD-3-Clause
 */

namespace WebinoData\Config\InputFilter\Input;

/**
 * Adds ability to set input as required
 */
trait RequirableTrait
{
    /**
     * @param bool $value
     * @return $this
     */
    public function setRequired($value = true)
    {
        $this->spec['required'] = $value;
        return $this;
    }
}
