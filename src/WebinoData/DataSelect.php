<?php

namespace WebinoData;

use WebinoData\Event\DataEvent;
use Zend\Db\Sql\Expression;
use Zend\Db\Sql\Select as SqlSelect;

/**
 * Class DataSelect
 *
 * @property \Zend\Db\Sql\Where $where
 * @property \Zend\Db\Sql\Having $having
 */
class DataSelect
{
    use Select\ColumnsTrait;
    use Select\CombineTrait;
    use Select\ConfigureTrait;
    use Select\GroupTrait;
    use Select\HavingTrait;
    use Select\JoinTrait;
    use Select\LimitTrait;
    use Select\OrderTrait;
    use Select\RawStateTrait;
    use Select\ResetTrait;
    use Select\SearchTrait;
    use Select\WhereTrait;

    /**
     * @var AbstractDataService
     */
    protected $store;

    /**
     * @var SqlSelect
     */
    protected $sqlSelect;

    /**
     * @var DataEvent
     */
    protected $event;

    /**
     * @var string|null
     */
    protected $hash;

    /**
     * @var array
     */
    protected $flags = [];

    /**
     * @var array
     */
    protected $subSelects = [];

    /**
     * @var array
     */
    protected $params = [];

    /**
     * @var array
     */
    protected $subParams = [];

    /**
     * @var bool
     */
    protected $cached = true;

    /**
     * @param AbstractDataService $store
     * @param SqlSelect $select
     */
    public function __construct(AbstractDataService $store, SqlSelect $select)
    {
        $this->store = $store;
        $this->sqlSelect = $select;
    }

    /**
     * @return AbstractDataService
     */
    public function getStore()
    {
        return $this->store;
    }

    /**
     * @return SqlSelect
     */
    public function getSqlSelect()
    {
        return $this->sqlSelect;
    }

    /**
     * @return string
     */
    public function getSqlString()
    {
        return $this->store->getSql()->buildSqlString($this->sqlSelect);
    }

    /**
     * @return DataEvent
     */
    public function getEvent()
    {
        if (null === $this->event) {
            $this->event = clone $this->store->getEvent();
            $this->event->setSelect($this)->setStore($this->store);
        }
        return $this->event;
    }

    /**
     * @return string
     */
    public function getHash()
    {
        return md5((string) $this . serialize($this->subParams) . serialize($this->flags) . $this->hash);
    }

    /**
     * @param string|array|null $hash
     * @return $this
     */
    public function setHash($hash)
    {
        $this->hash .= is_array($hash) ? md5(serialize($hash)) : $hash;
        return $this;
    }

    /**
     * @param string $name
     * @return bool
     */
    public function hasFlag($name)
    {
        return !empty($this->flags[(string) $name]);
    }

    /**
     * @param string $name
     * @param bool|true $value
     * @return $this
     */
    public function setFlag($name, $value = true)
    {
        if (null === $value) {
            unset($this->flags[(string) $name]);
        }
        $this->flags[(string) $name] = (bool) $value;
        return $this;
    }

    /**
     * Return foreign sub-select
     *
     * @param string $name
     * @return $this|null
     */
    public function getSubSelect($name)
    {
        return !empty($this->subSelects[$name]) ? $this->subSelects[$name] : null;
    }

    /**
     * Add foreign sub-select
     *
     * @param string $name
     * @param self $select
     * @return $this
     */
    public function setSubSelect($name, self $select)
    {
        $select->setHash($this->getHash());
        $this->subSelects[$name] = $select;
        return $this;
    }

    /**
     * Get select parameters
     *
     * @return array
     */
    public function getParams()
    {
        return $this->params;
    }

    /**
     * Set select parameters
     *
     * @param array $params
     * @return $this
     */
    public function setParams(array $params)
    {
        $this->params = $params;
        return $this;
    }

    /**
     * Set select parameter
     *
     * @param string $name Select parameter name
     * @param mixed $value Select parameter value
     * @return $this
     */
    public function setParam($name, $value)
    {
        $this->params[$name] = (string) $value;
        return $this;
    }

    /**
     * Get sub-select params
     *
     * @param string $name
     * @return array
     */
    public function getSubParams($name)
    {
        return isset($this->subParams[$name]) ? (array) $this->subParams[$name] : [];
    }

    /**
     * Set sub-select params
     *
     * @param string $name
     * @param array $params
     * @return $this
     */
    public function setSubParams($name, array $params)
    {
        isset($this->subParams[$name]) or $this->subParams[$name] = [];
        $this->subParams[$name] = array_replace($this->subParams[$name], $params);
        return $this;
    }

    /**
     * @param array $params Select parameters
     * @return \Zend\Db\Adapter\Driver\ResultInterface
     */
    public function execute($params = [])
    {
        $sql = $this->store->getSql();

        try {

            return $sql->prepareStatementForSqlObject($this->sqlSelect)->execute(array_merge($this->params, $params));

        } catch (\Exception $exc) {
            throw new Exception\RuntimeException(
                sprintf(
                    'Statement could not be executed %s',
                    $sql->buildSqlString($this->sqlSelect)
                ) . '; ' . $exc->getPrevious()->getMessage(),
                $exc->getCode(),
                $exc
            );
        }
    }
    /**
     * @return int
     */
    public function count(): int
    {
        $this->resetLimit();
        $this->resetOffset();
        $this->resetOrder();

        $columns = $this->getColumns();
        $columns['c'] = $this->resolveCountGroupExpression($this);

        $this->columns($columns);

        try {
            $result = $this->execute();
        } catch (\Throwable $exc) {
            // TODO better exception
            throw new \RuntimeException('Could not execute SQL ' . $this->getSqlString(), $exc->getCode(), $exc);
        }

        $row = $result->current();
        $resultCount = $result->count();

        return (int) (1 < $resultCount ? $resultCount : ( $row['c'] ?? 0));
    }

    /**
     * @param DataSelect $select
     * @return Expression
     */
    private function resolveCountGroupExpression(DataSelect $select) : Expression
    {
        $group = $select->getGroup();

        if (!empty($group)) {
            if (!is_string($group)) {
                $group = current($group);
                $group instanceof Expression and $group = $group->getExpression();
            }
        }

        return new Expression(is_string($group) ? 'COUNT(DISTINCT ' . $group . ')' : 'COUNT(*)');
    }

    /**
     * Variable overloading
     *
     * @param string $name
     * @throws \InvalidArgumentException
     * @return mixed
     */
    public function __get($name)
    {
        switch (strtolower($name)) {
            case 'where':
                return $this->sqlSelect->where;
            case 'having':
                return $this->sqlSelect->having;
            default:
                // TODO better exception
                throw new \InvalidArgumentException(
                    sprintf('Not a valid magic property `%s`', $name)
                );
        }
    }

    /**
     * @return string
     */
    public function __toString()
    {
        try {
            return $this->getSqlString();
        } catch (\Exception $exc) {
            // TODO use logger
            error_log($exc);
        }

        return '';
    }

    /**
     * Clone data select
     */
    public function __clone()
    {
        $this->sqlSelect = clone $this->sqlSelect;

        $helpers = [
            'configureHelper',
            'columnsHelper',
            'joinHelper',
            'whereHelper',
            'searchHelper',
            'orderHelper',
        ];

        foreach ($helpers as $helper) {
            if (isset($this->{$helper})) {
                $this->{$helper} = clone $this->{$helper};
                $this->{$helper}->setSelect($this);
            }
        }
    }

    /**
     * @TODO remove, deprecated
     * @deprecated, use getHash() instead
     *    use Select\PredicateTrait;
     * @return string
     */
    public function hash()
    {
        return $this->getHash();
    }

    /**
     * @TODO deprecated, remove
     * @deprecated use setSubSelect() and getSubSelect() instead
     *
     * @param string $name
     * @param self|null $select
     * @return $this|null
     */
    public function subSelect($name, self $select = null)
    {
        if (null === $select) {
            return $this->getSubSelect($name);
        }
        return $this->setSubSelect($name, $select);
    }

    /**
     * @TODO deprecated, remove
     * @deprecated use setSubParams() and getSubParams() instead
     *
     * @param string $name
     * @param array $params
     * @return $this|array
     */
    public function subParams($name, array $params = [])
    {
        if (empty($params)) {
            return $this->subParams[$name] ?? [];
        }

        isset($this->subParams[$name]) or $this->subParams[$name] = [];
        $this->subParams[$name] = array_replace($this->subParams[$name], $params);

        return $this;
    }

    /**
     * Returns when when cache select
     *
     * @return bool
     */
    public function isCached(): bool
    {
        return $this->cached;
    }

    /**
     * Set true to use select cache
     *
     * @param bool $cached
     * @return self
     */
    public function setCached(bool $cached = true)
    {
        $this->cached = $cached;
        return $this;
    }
}
