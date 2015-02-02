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
 * Foreign Id data type
 */
class ForeignId extends Id
{
    /**
     * @param string $name
     */
    public function __construct($name)
    {
        parent::__construct($name);
    }

    /**
     * Nullable Id
     *
     * @return self
     */
    public function setNull()
    {
        $this->spec['required'] = true;
        $this->spec['fallback_value'] = null;
        return $this;
    }
}
