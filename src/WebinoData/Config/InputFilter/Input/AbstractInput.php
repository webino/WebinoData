<?php
/**
 * Webino (http://webino.sk)
 *
 * @link        https://github.com/webino/WebinoData for the canonical source repository
 * @copyright   Copyright (c) 2012-2017 Webino, s. r. o. (http://webino.sk)
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
     * @return $this
     */
    protected function setName($name)
    {
        $this->spec['name'] = (string) $name;
        return $this;
    }

    /**
     * @param array $filters
     * @return $this
     */
    public function setFilters(array $filters)
    {
        $this->setSubOptions('filters', $filters);
        return $this;
    }

    /**
     * @param array $validators
     * @return $this
     */
    public function setValidators(array $validators)
    {
        $this->setSubOptions('validators', $validators);
        return $this;
    }

    /**
     * @param string $section
     * @param array $options
     * @return $this
     */
    protected function setSubOptions($section, array $options)
    {
        foreach ($options as $key => $option) {
            $index = is_string($key) ? $key : (string) $option;
            $this->spec[$section][$index] = is_array($option) ? $option : ['name' => (string) $option];
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
