<?php
/**
 * Created by PhpStorm.
 * User: kwhat
 * Date: 2/27/17
 * Time: 11:23 PM
 */

namespace Slim\PDO\Clause;

use Slim\PDO\AbstractClause;

class Grouping extends AbstractClause
{
    /**
     * @var string $rule
     */
    protected $rule;

    /**
     * @var \Slim\PDO\AbstractClause[]
     */
    protected $clauses;

    /**
     * Grouping constructor.
     * @param string $rule
     * @param AbstractClause[] $clauses
     */
    public function __construct($rule, $clauses)
    {
        $this->rule = $rule;
        $this->clauses = $clauses;
    }

    public function __toString()
    {
        return '(' . implode(") {$this->rule} (", $this->clauses) . ')';
    }
}
