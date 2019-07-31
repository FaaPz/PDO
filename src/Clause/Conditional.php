<?php

/**
 * @license MIT
 * @license http://opensource.org/licenses/MIT
 */

namespace FaaPz\PDO\Clause;

use FaaPz\PDO\DatabaseException;
use FaaPz\PDO\QueryInterface;

class Conditional implements QueryInterface
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
    public function __construct(string $column, string $operator, $value)
    {
        $this->column = $column;
        $this->operator = strtoupper(trim($operator));
        $this->value = $value;
    }

    /**
     * @return mixed[]
     */
    public function getValues() : array
    {
        $values = $this->value;
        if (!is_array($values)) {
            $values = [$values];
        }

        return $values;
    }

    /**
     * @throws DatabaseException
     *
     * @return string
     */
    public function __toString() : string
    {
        $sql = "{$this->column} {$this->operator}";
        switch ($this->operator) {
            case 'BETWEEN':
            case 'NOT BETWEEN':
                if (count($this->getValues()) != 2) {
                    throw new DatabaseException('Conditional operator "BETWEEN" requires two arguments');
                }

                $sql .= ' (? AND ?)';
                break;

            case 'IN':
            case 'NOT IN':
                if (count($this->getValues()) < 1) {
                    throw new DatabaseException('Conditional operator "IN" requires at least one argument');
                }

                $sql .= ' ('.substr(str_repeat('?, ', count($this->getValues())), 0, -2).')';
                break;

            default:
                $sql .= ' ?';
        }

        return $sql;
    }
}
