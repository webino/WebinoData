<?php
/**
 * Webino (http://webino.sk)
 *
 * @link        https://github.com/webino/WebinoData for the canonical source repository
 * @copyright   Copyright (c) 2012-2016 Webino, s. r. o. (http://webino.sk)
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
     * @param array $input
     */
    public function __construct(array $input = [])
    {
        foreach ($input as $item) {
            if ($item instanceof Input\InputInterface) {
                $this->push($item);
            }
        }
    }

    /**
     * @param Input\InputInterface $input
     * @return $this
     */
    public function push(Input\InputInterface $input)
    {
        $name = $input->getName();
        if ('type' === $name) {
            // todo issue: can't use named index cause it changes the name of the input (report the issue!)
            // issue conflicts with the input filter type key
            $this->spec[] = $input->toArray();
        } else {
            $this->spec[$name] = $input->toArray();
        }
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
