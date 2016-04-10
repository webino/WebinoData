<?php
/**
 * Webino (http://webino.sk)
 *
 * @link        https://github.com/webino/WebinoData for the canonical source repository
 * @copyright   Copyright (c) 2012-2016 Webino, s. r. o. (http://webino.sk)
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
     * @param array $options
     * @return $this
     */
    public function setOptions(array $options)
    {
        foreach ($options as $key => $option) {
            if ($option instanceof InputFilter\InputFilter) {
                $this->options['parameters']['config']['input_filter'] = $option->toArray();

            } elseif (isset($this->options[$key])) {
                $this->options[$key] = array_replace_recursive($this->options[$key], $option);

            } else {
                $this->options[$key] = $option;
            }
        }

        return $this;
    }

    /**
     * @return array
     */
    public function toArray()
    {
        return $this->options;
    }
}
