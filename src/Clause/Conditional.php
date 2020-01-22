<?php

/**
 * @license MIT
 * @license http://opensource.org/licenses/MIT
 */

namespace FaaPz\PDO\Clause;

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
    public function getValues(): array
    {
        $values = $this->value;
        if (!is_array($values)) {
            $values = [$values];
        }

        $count = count($values);
        for ($i = 0; $i < $count; $i++) {
            if ($values[$i] instanceof QueryInterface) {
                $value = $values[$i]->getValues();
                array_splice($values, $i, 1, $value);
                $i += count($value);
            }
        }

        return $values;
    }

    /**
     * @param mixed $value
     *
     * @return string
     */
    protected function getPlaceholder($value): string
    {
        $placeholder = '?';
        if ($value instanceof QueryInterface) {
            $placeholder = "{$value}";
        }

        return $placeholder;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        $sql = "{$this->column} {$this->operator} ";
        switch ($this->operator) {
            case 'BETWEEN':
            case 'NOT BETWEEN':
                if (count($this->value) != 2) {
                    trigger_error(
                        "Conditional operator '{$this->operator}' requires two arguments",
                        E_USER_ERROR
                    );
                }

                $sql .= "({$this->getPlaceholder($this->value[0])} AND {$this->getPlaceholder($this->value[1])})";
                break;

            case 'IN':
            case 'NOT IN':
                if (count($this->value) < 1) {
                    trigger_error(
                        "Conditional operator '{$this->operator}' requires at least one argument",
                        E_USER_ERROR
                    );
                }

                $placeholders = '';
                foreach ($this->value as $value) {
                    if (!empty($placeholders)) {
                        $placeholders .= ', ';
                    }

                    $placeholders .= $this->getPlaceholder($value);
                }
                $sql .= "({$placeholders})";
                break;

            default:
                $sql .= $this->getPlaceholder($this->value);
        }

        return $sql;
    }
}
