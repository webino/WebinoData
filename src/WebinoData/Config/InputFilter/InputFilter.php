<?php
/**
 * Webino (http://webino.sk)
 *
 * @link        https://github.com/webino/WebinoData for the canonical source repository
 * @copyright   Copyright (c) 2012-2014 Webino, s. r. o. (http://webino.sk)
 * @author      Peter Bačinský <peter@bacinsky.sk>
 * @license     BSD-3-Clause
 */

namespace WebinoData\Config\InputFilter;

/**
 * Input filter configurator
 */
class InputFilter
{
    /**
     * @var array
     */
    protected $spec = [];

    /**
     * @param InputInterface $input
     * @return self
     */
    public function push(Input\InputInterface $input)
    {
        $this->spec[$input->getName()] = $input->toArray();
        return $this;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return $this->spec;
    }
}
