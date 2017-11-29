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
 * Trait RelationsTrait
 * @TODO refactor
 * @TODO service word deprecated, use store instead
 */
trait RelationsTrait
{
    use TraitBase;

    /**
     * @var array
     */
    protected $hasOneList = [];

    /**
     * @var array
     */
    protected $hasManyList = [];

    /**
     * @var array
     * @TODO use Store instead of Service
     */
    protected $hasOneService = [];

    /**
     * @var array
     * @TODO use Store instead of Service
     */
    protected $hasManyService = [];

    /**
     * @deprecated Use setHasManyService instead, it prevents circular dependency exception
     * @param string $name
     * @param StoreInterface $store
     * @param array $options
     * @return $this
     */
    public function setHasOne($name, StoreInterface $store, array $options = [])
    {
        isset($this->hasOneList[$name])
            or $this->hasOneList[$name] = [];

        // TODO use store key instead of service
        $this->hasOneList[$name]['service'] = $store;
        $this->hasOneList[$name]['options'] = $options;
        return $this;
    }

    /**
     * @param string $name
     * @param string $storeName
     * @param array $options
     * @return $this
     */
    public function setHasOneService($name, $storeName, array $options = [])
    {
        if (empty($name)) {
            // TODO exception
            throw new \InvalidArgumentException('Name cannot be null');
        }

        isset($this->hasOneService[$name])
            or $this->hasOneService[$name] = [];

        $this->hasOneService[$name]['serviceName'] = $storeName;
        $this->hasOneService[$name]['options']     = $options;
        return $this;
    }

    /**
     * @param string $name
     * @return bool
     */
    public function hasOne($name)
    {
        if (!empty($this->hasOneList[$name])) {
            return true;
        }
        return !empty($this->hasOneService[$name]);
    }

    /**
     * @param string $name
     * @return StoreInterface
     * @throws \OutOfBoundsException
     */
    protected function resolveOne($name)
    {
        if (empty($this->hasOneList[$name])) {
            if (empty($this->hasOneService[$name])) {
                // TODO exception
                throw new \OutOfBoundsException('Hasn\'t one ' . $name . '; ' . $this->getTableName());
            } else {
                $storeName = $this->hasOneService[$name]['serviceName'];
                $this->hasOneService[$name]['service'] = $this->getServiceManager()->get($storeName);
                return $this->hasOneService[$name];
            }
        }

        return $this->hasOneList[$name];
    }

    /**
     * @param string|null $name
     * @return $this|array
     */
    public function one($name = null)
    {
        if (null === $name) {
            return $this->getHasOneList();
        }
        $item = $this->resolveOne($name);
        return $item['service'];
    }

    /**
     * Returns 1:1 sub-store options
     *
     * @param string $name
     * @return array
     */
    public function oneSpec($name)
    {
        $item = $this->resolveOne($name);
        return $item['options'];
    }

    /**
     * @deprecated use oneSpec() instead
     * @param string $name
     * @return array
     */
    public function oneOptions($name)
    {
        return $this->oneSpec($name);
    }

    /**
     * @return array
     * @deprecated use one()
     */
    public function getHasOneList()
    {
        $hasOne = $this->hasOneList;
        if (!empty($this->hasOneService)) {
            foreach ($this->hasOneService as $name => $item) {

                empty($item['service'])
                    and $item = $this->resolveOne($name);

                $hasOne[$name] = $item;
            }
        }

        return $hasOne;
    }

    /**
     * @return array
     */
    public function getHasOneService()
    {
        return $this->hasOneService;
    }

    /**
     * @deprecated Use setHasManyService instead, it prevents circular dependency exception
     * @param string $name
     * @param StoreInterface $store
     * @param array $options
     * @return $this
     */
    public function setHasMany($name, StoreInterface $store, array $options = [])
    {
        isset($this->hasManyList[$name])
            or $this->hasManyList[$name] = [];

        $this->hasManyList[$name]['service'] = $store;
        $this->hasManyList[$name]['options'] = $options;
        return $this;
    }

    /**
     * @param string $name
     * @param string $storeName
     * @param array $options
     * @return $this
     */
    public function setHasManyService($name, $storeName, array $options = [])
    {
        if (empty($name)) {
            // TODO exception
            throw new \InvalidArgumentException('Name cannot be null');
        }

        isset($this->hasManyService[$name])
            or $this->hasManyService[$name] = [];

        $this->hasManyService[$name]['serviceName'] = $storeName;
        $this->hasManyService[$name]['options']     = $options;
        return $this;
    }

    /**
     * @param string $name
     * @return bool
     */
    public function hasMany($name)
    {
        if (!empty($this->hasManyList[$name])) {
            return true;
        }
        return !empty($this->hasManyService[$name]);
    }

    /**
     * @param string $name
     * @return $this
     * @throws \OutOfBoundsException
     */
    protected function resolveMany($name)
    {
        if (empty($this->hasManyList[$name])) {
            if (empty($this->hasManyService[$name])) {
                // TODO exception
                throw new \OutOfBoundsException('Hasn\'t many ' . $name . '; ' . $this->getTableName());
            } else {
                $storeName = $this->hasManyService[$name]['serviceName'];
                $this->hasManyService[$name]['service'] = $this->getServiceManager()->get($storeName);
                return $this->hasManyService[$name];
            }
        }

        return $this->hasManyList[$name];
    }

    /**
     * @param string|null $name
     * @return $this|array
     */
    public function many($name = null)
    {
        if (null === $name) {
            return $this->getHasManyList();
        }
        $item = $this->resolveMany($name);
        return $item['service'];
    }

    /**
     * Returns n:m sub-store options
     *
     * @param string $name
     * @return array
     */
    public function manySpec($name)
    {
        $item = $this->resolveMany($name);
        return $item['options'];
    }

    /**
     * @deprecated use manySpec() instead
     * @param string $name
     * @return array
     */
    public function manyOptions($name)
    {
        return $this->manySpec($name);
    }

    /**
     * @return array
     * @deprecated use many()
     */
    public function getHasManyList()
    {
        $hasMany = $this->hasManyList;
        if (!empty($this->hasManyService)) {
            foreach ($this->hasManyService as $name => $item) {

                empty($item['service'])
                    and $item = $this->resolveMany($name);

                $hasMany[$name] = $item;
            }
        }

        return $hasMany;
    }

    /**
     * @return array
     */
    public function getHasManyService()
    {
        return $this->hasManyList;
    }
}
