<?php

/**
 * @license MIT
 * @license http://opensource.org/licenses/MIT
 */

namespace FaaPz\PDO\Clause;

class Grouping implements ConditionalInterface
{
    /** @var string $operator */
    protected $operator;

    /** @var array<ConditionalInterface> $value */
    protected $value;

    /**
     * @param string               $operator
     * @param ConditionalInterface $clause
     * @param ConditionalInterface ...$clauses
     */
    public function __construct(string $operator, ConditionalInterface $clause, ConditionalInterface ...$clauses)
    {
        array_unshift($clauses, $clause);

        $this->operator = strtoupper(trim($operator));
        $this->value = $clauses;
    }

    /**
     * @return array
     */
    public function getValues(): array
    {
        $values = [];
        foreach ($this->value as $clause) {
            $values = array_merge($values, $clause->getValues());
        }

        return $values;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        $sql = '';
        foreach ($this->value as $clause) {
            if (!empty($sql)) {
                $sql .= " {$this->operator} ";
            }

            if ($clause instanceof self) {
                $sql .= "({$clause})";
            } else {
                $sql .= "{$clause}";
            }
        }

        return $sql;
    }
}
