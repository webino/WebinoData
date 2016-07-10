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
 * Base class for all input filter input configurators
 */
abstract class AbstractInput implements InputInterface
{
    /**
     * @var string
     */
    protected $name;

    /**
     * @var array
     */
    protected $spec = ['required' => false];

    /**
     * {@inheritDoc}
     */
    public function getName()
    {
        return $this->spec['name'];
    }

    /**
     * @param string $name
     * @return self
     */
    protected function setName($name)
    {
        $this->spec['name'] = (string) $name;
        return $this;
    }

    /**
     * @param array $filters
     * @return AbstractInput
     */
    public function setFilters(array $filters)
    {
        foreach ($filters as $key => $filter) {
            $this->spec['filters'][is_string($key) ? $key : (string) $filter] = ['name' => (string) $filter];
        }
        return $this;
    }

    /**
     * @param array $values
     * @return $this
     */
    public function setAllowedValues(array $values)
    {
        isset($this->spec['validators']['inArray']) or $this->spec['validators']['inArray'] = ['name' => 'InArray'];
        $this->spec['validators']['inArray']['options']['haystack'] = $values;
        return $this;
    }

    /**
     * {@inheritDoc}
     */
    public function toArray()
    {
        return $this->spec;
    }
}
