<?php
/**
 * Webino (http://webino.sk)
 *
 * @link        https://github.com/webino/WebinoData for the canonical source repository
 * @copyright   Copyright (c) 2013-2017 Webino, s. r. o. (http://webino.sk)
 * @author      Peter Bačinský <peter@bacinsky.sk>
 * @license     BSD-3-Clause
 */

namespace WebinoData\Plugin;

/**
 * Interface OptionsInterface
 */
interface OptionsInterface
{
    /**
     * Set plugin options
     *
     * @param  array|\Traversable $options
     * @return $this
     * @throws \InvalidArgumentException
     */
    public function setOptions($options);
}
