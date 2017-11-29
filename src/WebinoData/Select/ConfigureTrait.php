<?php
/**
 * Webino (http://webino.sk)
 *
 * @link        https://github.com/webino/WebinoData for the canonical source repository
 * @copyright   Copyright (c) 2013-2017 Webino, s. r. o. (http://webino.sk)
 * @author      Peter Bačinský <peter@bacinsky.sk>
 * @license     BSD-3-Clause
 */

namespace WebinoData\Select;

/**
 * Trait ConfigureTrait
 */
trait ConfigureTrait
{
    /**
     * @var Configure
     */
    protected $configureHelper;

    /**
     * @return Configure
     */
    public function getConfigureHelper()
    {
        if (null === $this->configureHelper) {
            $this->configureHelper = new Configure($this);
        }
        return $this->configureHelper;
    }

    /**
     * @param Configure $configureHelper
     * @return $this
     */
    public function setConfigureHelper(Configure $configureHelper)
    {
        $this->configureHelper = $configureHelper;
        return $this;
    }

    /**
     * @param array $config
     * @return $this
     */
    public function configure(array $config)
    {
        $this->getConfigureHelper()->configure($config);
        return $this;
    }
}
