<?php

/**
 * @license MIT
 * @license http://opensource.org/licenses/MIT
 */

namespace FaaPz\PDO\Clause;

use FaaPz\PDO\StatementInterface;

class Conditional implements StatementInterface
{
    /** @var string $column */
    protected $column;

    /** @var string $operator */
    protected $operator;

    /** @var mixed $value */
    protected $value;

    /**
     * @param string $column
     * @param string $operator
     * @param mixed  $value
     */
    public function __construct($column, $operator, $value)
    {
        $this->column = $column;
        $this->operator = strtoupper($operator);
        $this->value = $value;
    }

    /**
     * @return array
     */
    public function getValues()
    {
        $values = $this->value;

        if (!is_array($values)) {
            $values = [$values];
        }

        return $values;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        $sql = "{$this->column} {$this->operator}";
        if (preg_match('/IN$/', $this->operator)) {
            $sql .= ' ('.preg_replace('/, $/', '', str_repeat('?, ', count($this->getValues()))).')';
        } elseif (preg_match('/BETWEEN$/', $this->operator)) {
            $sql = "({$sql} ? AND ?)";
        } else {
            $sql .= ' ?';
        }

        return $sql;
    }
}
