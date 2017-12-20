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
 * Adds ability to set fallback value
 */
trait DefaultableTrait
{
    use RequirableTrait;

    /**
     * @param int|string|bool|null $value
     * @return $this
     */
    public function setDefault($value)
    {
        $this->spec['fallback_value'] = $value;
        $this->setRequired();
        return $this;
    }
}
