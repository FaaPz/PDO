<?php

/**
 * @license MIT
 * @license http://opensource.org/licenses/MIT
 */
namespace Slim\PDO\Clause;

use Slim\PDO\AbstractClause;

/**
 * Class WhereClause.
 *
 * @author Fabian de Laender <fabian@faapz.nl>
 */
class Conditional extends AbstractClause
{
    /** @var string $column */
    protected $column;

    /** @var string $operator */
    protected $operator;

    /** @var mixed $value */
    protected $value;

    /**
     * Conditional constructor.
     * @param string $column
     * @param string $operator
     * @param mixed $value
     */
    public function __construct($column, $operator, $value)
    {
        $this->column = $column;
        $this->operator = $operator;
        $this->value = $value;
    }

    public function getValue() {
        return $this->value;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return "{$this->column} {$this->operator} ?";
    }
}
