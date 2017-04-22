<?php

/**
 * @license MIT
 * @license http://opensource.org/licenses/MIT
 */
namespace Slim\PDO\Clause;

class Grouping extends Conditional
{
    /**
     * @var string $rule
     */
    protected $rule;

    /**
     * @var Conditional[]
     */
    protected $clauses;

    /**
     * Grouping constructor.
     * @param string $rule
     * @param Conditional[] $clauses
     */
    public function __construct($rule, array $clauses)
    {
        $this->rule = $rule;
        $this->clauses = $clauses;
    }

    public function __toString()
    {
        return '(' . implode(") {$this->rule} (", $this->clauses) . ')';
    }
}
