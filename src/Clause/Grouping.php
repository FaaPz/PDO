<?php

/**
 * @license MIT
 * @license http://opensource.org/licenses/MIT
 */

declare(strict_types=1);

namespace FaaPz\PDO\Clause;

class Grouping extends Conditional
{
    /** @var Conditional[] $value */
    protected $value;

    /**
     * @param string      $rule
     * @param Conditional $clause
     * @param Conditional ...$clauses
     */
    public function __construct(string $rule, Conditional $clause, Conditional ...$clauses)
    {
        array_unshift($clauses, $clause);
        parent::__construct('', $rule, $clauses);
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
