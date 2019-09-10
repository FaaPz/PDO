<?php

/**
 * @license MIT
 * @license http://opensource.org/licenses/MIT
 */

namespace FaaPz\PDO\Clause;

class Grouping extends Conditional
{
    /** @var Conditional[] $value */
    protected $value;

    /**
     * @param string      $rule
     * @param Conditional ...$clauses
     */
    public function __construct(string $rule, Conditional ...$clauses)
    {
        parent::__construct('', strtoupper(trim($rule)), $clauses);
    }

    /**
     * @return array
     */
    public function getValues() : array
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
    public function __toString() : string
    {
        $sql = '';
        foreach ($this->value as $clause) {
            if ($clause instanceof self) {
                $clause = "({$clause})";
            }

            $sql .= "{$clause} {$this->operator} ";
        }

        return preg_replace('/'.preg_quote(" $this->operator ", '/').'$/', '', $sql);
    }
}
