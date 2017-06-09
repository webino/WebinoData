<?php

namespace WebinoData\Select;

use ArrayObject;
use WebinoData\DataSelect;
use WebinoI18nSanitizeLib\Sanitize;
use Zend\Db\Sql\Expression;
use Zend\Db\Sql\Predicate\PredicateSet;
use Zend\Db\Sql\Select;

/**
 * Class Search
 */
class Search extends AbstractHelper
{
    /**
     * @var array
     */
    protected $search = [];

    /**
     * @var Sanitize
     */
    protected $sanitize;

    /**
     * @return Sanitize
     */
    public function getSanitize()
    {
        if (null === $this->sanitize) {
            $this->sanitize = new Sanitize;
        }
        return $this->sanitize;
    }

    /**
     * @param Sanitize $sanitize
     * @return $this
     */
    public function setSanitize(Sanitize $sanitize)
    {
        $this->sanitize = $sanitize;
        return $this;
    }

    /**
     * @return array
     */
    public function getSearch()
    {
        return $this->search;
    }

    /**
     * @param mixed $term
     * @param array $columns
     * @param string $combination
     * @return $this
     */
    public function search($term, array $columns = [], $combination = PredicateSet::OP_AND)
    {
        if (empty($term) && !is_numeric($term)) {
            return $this;
        }

        if (is_array($term)) {
            foreach ($term as $subKey => $subTerms) {
                foreach ((array) $subTerms as $subTerm) {

                    empty($subKey) || (empty($subTerm) && !is_numeric($subTerm))
                        or $this->search($subTerm, [$subKey], $combination);
                }
            }
            return $this;
        }

        $_term    = $this->sanitizeSearchTerm($term);
        $platform = $this->select->getStore()->getPlatform();
        $where    = new ArrayObject;
        $having   = new ArrayObject;

        $havingCols = array_merge(
            $this->resolveJoinColumns(),
            $this->resolveExpressionColumns()
        );

        foreach ($this->resolveSearchTermParts($term, $_term) as $word) {
            if (empty($word) && !is_numeric($word)) {
                continue;
            }

            foreach ($columns as $column) {
                $columnParts = explode('.', $column);
                $identifier  = (2 === count($columnParts))
                                ? $platform->quoteIdentifier($columnParts[0])
                                  . '.' . $platform->quoteIdentifier($columnParts[1])
                                : $platform->quoteIdentifier($column);

                if (preg_match('~_id$~', $column)) {
                    // id column
                    $where[] = $identifier . ' = ' . $platform->quoteValue($word);
                    continue;
                }

                $word     = $this->sanitizeSearchTerm($word, '%');
                $target   = !empty($havingCols[$column]) ? $having : $where;
                $target[] = $identifier . ' LIKE ' . $platform->quoteValue('%' . $word . '%');
            }
        }

        if (!count($where) && !count($having)) {
            return $this;
        }

        foreach ($columns as $column) {
            isset($this->search[$column])  or $this->search[$column] = [];
            in_array($_term, $this->search) or $this->search[$column][] = $_term;
        }

        $predicate = function (ArrayObject $columns) {
            return '(' . join(' ' . PredicateSet::OP_OR . ' ', $columns->getArrayCopy()) . ')';
        };

        count($where)  and $this->select->where($predicate($where), $combination);
        count($having) and $this->select->having($predicate($having), $combination);

        return $this;
    }

    /**
     * Returns array of columns to use having instead of where
     *
     * @return array
     */
    private function resolveJoinColumns()
    {
        $result = [];
        foreach ($this->select->getJoins() as $join) {
            if (Select::JOIN_INNER === $join['type']) {
                continue;
            }

            foreach (array_keys($join['columns']) as $column) {
                $result[$column] = true;
            }
        }
        return $result;
    }

    /**
     * @return array
     */
    private function resolveExpressionColumns()
    {
        $cols = [];
        foreach ($this->select->getColumns() as $name => $column) {
            if ($column instanceof Expression) {
                $expression = $column->getExpression();

                false === strpos($expression, 'SELECT')
                    or $cols[$name] = true;
            }
        }
        return $cols;
    }

    /**
     * @param string $term
     * @param string $_term
     * @return array
     */
    private function resolveSearchTermParts($term, $_term)
    {
        if ('"' === $term[0]
            && '"' === $term[mb_strlen($term, 'utf-8') - 1]
        ) {
            // exact term
            return [trim($_term, '"')];
        }

        return explode(' ', $_term);
    }

    /**
     * @param string $term
     * @param string $replacement
     * @return string
     */
    private function sanitizeSearchTerm($term, $replacement = ' ')
    {
        $_term = trim($term);
        if (is_numeric($_term)) {
            return $_term;
        }


        $this->fixDateSearch($_term);
        $_term = $this->getSanitize()->filter($_term);

        return preg_replace('~[^a-zA-Z0-9_-]+~', $replacement, $_term);
    }

    /**
     * @param &$term
     */
    private function fixDateSearch(&$term)
    {
        if (!preg_match('~^[0-9]{1,2}\.[0-9]{1,2}(\.[0-9]{1,4})?$~', $term)) {
            return;
        }

        // fix year
        substr_count($term, '.') >= 3 or $term.= '.';
        list($day, $month, $year) = explode('.', $term);

        $term = sprintf(
            '%s-%s-%s',
            $year,
            str_repeat('0', 2 - strlen($month)) . $month,
            str_repeat('0', 2 - strlen($day)) . $day
        );
    }
}
