<?php
/**
 * Webino (http://webino.sk)
 *
 * @link        https://github.com/webino/WebinoData for the canonical source repository
 * @copyright   Copyright (c) 2013-2017 Webino, s. r. o. (http://webino.sk)
 * @author      Peter Bačinský <peter@bacinsky.sk>
 * @license     BSD-3-Clause
 */

namespace WebinoData\Store;

/**
 * Trait PluginTrait
 */
trait PluginTrait
{
    use TraitBase;

    /**
     * @var object[]
     */
    protected $plugins = [];

    /**
     * Initialize the data service plugin handlers
     *
     * @param array $config
     * @return $this
     */
    protected function initPlugin(array $config)
    {
        // TODO use getStoreManager() instead
        $stores = $this->getServiceManager();
        $events = $this->getEventManager();

        $attachedPlugins = [];
        foreach ($config as $pluginKey => $pluginName) {

            // resolve plugin settings
            $pluginOptions = [];
            if (is_array($pluginName)) {
                if (!empty($pluginName['plugin'])) {
                    $pluginName = $pluginName['plugin'];
                    unset($pluginName['plugin']);
                    $pluginOptions = $pluginName;

                } else {
                    $pluginOptions = $pluginName;
                    $pluginName    = $pluginKey;
                }
            }

            // do not attach the same plugin more than once
            if (isset($attachedPlugins[$pluginName])) {
                continue;
            }
            $attachedPlugins[$pluginName] = true;

            $plugin = $stores->get($pluginName);
            if (empty($plugin)) {
                continue;
            }

            // attach plugin
            $plugin = clone $plugin;
            $plugin->attach($events);
            $this->plugins[$pluginName] = $plugin;

            empty($pluginOptions)
                or $plugin->setOptions($pluginOptions);

            /** @var StoreInterface $this */
            ($plugin instanceof StoreAwareInterface)
                and $plugin->setStore($this);
        }

        return $this;
    }

    /**
     * Returns store plugin
     *
     * @param string|null $name
     * @return object
     */
    public function getPlugin($name = null)
    {
        $this->init();

        if (null === $name) {
            return $this->plugins;
        }
        if (empty($this->plugins[$name])) {
            return null;
        }

        return $this->plugins[$name];
    }

    /**
     * @TODO remove, deprecated
     * @deprecated use getPlugin()
     * @param string|null $name
     * @return object
     */
    public function plugin($name = null)
    {
        return $this->getPlugin($name);
    }
}
