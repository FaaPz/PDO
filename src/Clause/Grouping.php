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
     * @param Conditional ...$_
     */
    public function __construct(string $rule, Conditional $clause, Conditional ...$_)
    {
        array_unshift($_, $clause);
        parent::__construct('', $rule, $_);
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
            if ($clause instanceof self) {
                $clause = "({$clause})";
            }

            $sql .= "{$clause} {$this->operator} ";
        }

        return preg_replace('/' . preg_quote(" $this->operator ", '/') . '$/', '', $sql);
    }
}
