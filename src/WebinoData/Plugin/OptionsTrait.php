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
 * Trait OptionsTrait
 */
trait OptionsTrait
{
    /**
     * @var array
     */
    protected $options = [];

    /**
     * Set plugin options
     *
     * @param  array|\Traversable $options
     * @return $this
     * @throws \InvalidArgumentException
     */
    public function setOptions($options)
    {
        if (!is_array($options) && !$options instanceof \Traversable) {
            // TODO better exception
            throw new \InvalidArgumentException(sprintf(
                '"%s" expects an array or Traversable; received "%s"',
                __METHOD__,
                (is_object($options) ? get_class($options) : gettype($options))
            ));
        }

        foreach ($options as $key => $value) {
            $setter = 'set' . str_replace(' ', '', ucwords(str_replace('_', ' ', $key)));
            if (method_exists($this, $setter)) {
                $this->{$setter}($value);
            } elseif (array_key_exists($key, $this->options)) {
                $this->options[$key] = $value;
            } else {
                // TODO better exception
                throw new \InvalidArgumentException(sprintf(
                    'The option "%s" does not have a matching %s setter method or options[%s] array key',
                    $key, $setter, $key
                ));
            }
        }

        return $this;
    }

    /**
     * @return array
     */
    public function getOptions()
    {
        return $this->options;
    }
}
