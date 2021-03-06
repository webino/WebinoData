<?php

namespace WebinoData\Select;

use WebinoData\DataService;

/**
 * Class PredicateTrait
 */
trait PredicateTrait
{
    /**
     * @return DataService
     */
    abstract public function getStore();

    /**
     * @param \ArrayObject|array $predicate
     * @return array
     */
    protected function handlePredicate($predicate)
    {
        $newPredicate = [];

        foreach ($predicate as $key => $value) {
            $args = $this->handleVars([$key, $value]);
            $newPredicate[$args[0]] = $args[1];
        }

        return $newPredicate;
    }

    /**
     * @param mixed $subject
     * @return mixed
     */
    protected function handleVars($subject)
    {
        $this->replaceVars($subject);
        return $subject;
    }

    /**
     * @param array|string $subject
     * @return $this
     */
    private function replaceVars(&$subject)
    {
        if (is_string($subject)) {
            $this->replaceVarsInternal($subject);
            return $this;
        }

        foreach ($subject as &$str) {
            if (is_object($str)) {
                // todo replace in sql select?
                continue;
            }

            if (is_array($str)) {
                $this->replaceVars($str);
                continue;
            }

            $this->replaceVarsInternal($str);
        }

        return $this;
    }

    /**
     * @param string &$str
     * @return $this
     */
    private function replaceVarsInternal(&$str)
    {
        // TODO remove, {$tableName} deprecated, use {$this}
        if (false !== strpos($str, '{$tableName}')) {
            $str = str_replace('{$tableName}', $this->getStore()->getTableName(), $str);
        }
        if (false !== strpos($str, '{$this}')) {
            $str = str_replace('{$this}', $this->getStore()->getTableName(), $str);
        }
        return $this;
    }
}
