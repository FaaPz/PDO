<?php

/**
 * @license MIT
 * @license http://opensource.org/licenses/MIT
 */

namespace FaaPz\PDO\Clause;

use FaaPz\PDO\StatementInterface;

class Grouping implements StatementInterface
{
    /** @var string $rule */
    protected $rule;

    /** @var Conditional[]|Grouping[] $value */
    protected $value;

    /**
     * @param string                   $rule
     * @param Conditional[]|Grouping[] $clauses
     */
    public function __construct($rule, ...$clauses)
    {
        $this->rule = strtoupper($rule);
        $this->value = $clauses;
    }

    /**
     * @return array
     */
    public function getValues()
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
    public function __toString()
    {
        $sql = '';
        foreach ($this->value as $clause) {
            if ($clause instanceof self) {
                $sql .= "({$clause}) ";
            } else {
                $sql .= "{$clause} ";
            }

            $sql .= "{$this->rule} ";
        }

        return preg_replace("/{$this->rule} $/", '',  $sql);
    }
}
