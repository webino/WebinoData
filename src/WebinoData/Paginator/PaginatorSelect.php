<?php
/**
 * Webino (http://webino.sk)
 *
 * @link        https://github.com/webino/WebinoData for the canonical source repository
 * @copyright   Copyright (c) 2013-2017 Webino, s. r. o. (http://webino.sk)
 * @author      Peter Bačinský <peter@bacinsky.sk>
 * @license     BSD-3-Clause
 */

namespace WebinoData\Paginator;

use WebinoData\Select;
use WebinoData\Store\StoreInterface;
use Zend\Cache\Storage\Adapter\Filesystem as Cache;

/**
 * Class PaginatorSelect
 */
class PaginatorSelect extends AbstractPaginatorSelect
{
    /**
     * @var Cache
     */
    protected $cache;

    /**
     * @var string
     */
    protected $cacheKey;

    /**
     * @var array
     */
    protected $cacheTags = [];

    /**
     * @param Select $select
     * @param StoreInterface $store
     */
    public function __construct(Select $select, StoreInterface $store)
    {
        parent::__construct($select, $store);
        $this->cacheKey = $select->getHash();
    }

    /**
     * @return bool
     */
    public function hasCache()
    {
        return null !== $this->cache;
    }

    /**
     * @return Cache
     */
    protected function getCache()
    {
        return $this->cache;
    }

    /**
     * @param Cache $cache
     * @return $this
     */
    public function setCache(Cache $cache)
    {
        $this->cache = $cache;
        return $this;
    }

    /**
     * @return array
     */
    public function getCacheTags()
    {
        return $this->cacheTags;
    }

    /**
     * @param array $tags
     * @return $this
     */
    public function setCacheTags(array $tags)
    {
        $this->cacheTags = $tags;
        return $this;
    }

    /**
     * @return int
     */
    public function count()
    {
        if (!$this->hasCache()) {
            return parent::count();
        }

        $cache    = $this->getCache();
        $cacheKey = md5($this->cacheKey . '_count');
        $count    = $cache->getItem($cacheKey);

        if (null === $count) {
            // fetch count
            $count = parent::count();

            $cache->setItem($cacheKey, $count);
            $cache->setTags($cacheKey, $this->getCacheTags());
        }

        return $count;
    }
}
