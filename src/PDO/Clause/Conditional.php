<?php

/**
 * @license MIT
 * @license http://opensource.org/licenses/MIT
 */

namespace Slim\PDO\Clause;

use Slim\PDO\StatementInterface;

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
        $this->operator = $operator;
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
        $placeholders = '?';

        if (is_array($this->value)) {
            $placeholders = '('.rtrim(str_repeat('?, ', count($this->value)), ', ').')';
        }

        return "{$this->column} {$this->operator} {$placeholders}";
    }
}
