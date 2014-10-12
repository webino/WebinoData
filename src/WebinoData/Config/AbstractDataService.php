<?php
/**
 * Webino (http://webino.sk)
 *
 * @link        https://github.com/webino/WebinoData for the canonical source repository
 * @copyright   Copyright (c) 2012-2014 Webino, s. r. o. (http://webino.sk)
 * @author      Peter Bačinský <peter@bacinsky.sk>
 * @license     BSD-3-Clause
 */

namespace WebinoData\Config;

/**
 * Data service abstract configurator
 */
abstract class AbstractDataService
{
    /**
     * @var array
     */
    protected $options = [];

    /**
     * @return array
     */
    abstract protected function getSpec();

    /**
     * @return array
     */
    public function toArray()
    {
        return array_replace_recursive($this->getSpec(), $this->options);
    }
}
