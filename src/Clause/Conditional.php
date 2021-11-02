<?php

/**
 * @license MIT
 * @license http://opensource.org/licenses/MIT
 */

namespace FaaPz\PDO\Clause;

use FaaPz\PDO\QueryInterface;

class Conditional implements ConditionalInterface
{
    /** @var string $column */
    protected $column;

    /** @var string $operator */
    protected $operator;

    /** @var float|int|string|array<float|int|string>|MethodInterface|RawInterface $value */
    protected $value;

    /**
     * @param string                                                                $column
     * @param string                                                                $operator
     * @param float|int|string|array<float|int|string>|MethodInterface|RawInterface $value
     */
    public function __construct(string $column, string $operator, $value)
    {
        $this->column = $column;
        $this->operator = strtoupper(trim($operator));
        $this->value = $value;
    }

    /**
     * @return array<mixed>
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
    protected function renderPlaceholder($value): string
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
                if (!is_array($this->value) || count($this->value) != 2) {
                    trigger_error(
                        "Conditional operator '{$this->operator}' requires an array with exactly two arguments",
                        E_USER_ERROR
                    );
                }

                $sql .= "({$this->renderPlaceholder($this->value[0])} AND {$this->renderPlaceholder($this->value[1])})";
                break;

            case 'IN':
            case 'NOT IN':
                if (!is_array($this->value) || count($this->value) < 1) {
                    trigger_error(
                        "Conditional operator '{$this->operator}' requires an array with at least one argument",
                        E_USER_ERROR
                    );
                }

                $placeholders = '';
                foreach ($this->value as $value) {
                    if (!empty($placeholders)) {
                        $placeholders .= ', ';
                    }

                    $placeholders .= $this->renderPlaceholder($value);
                }
                $sql .= "({$placeholders})";
                break;

            default:
                $sql .= $this->renderPlaceholder($this->value);
        }

        return $sql;
    }
}
