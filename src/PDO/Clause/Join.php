<?php

/**
 * @license MIT
 * @license http://opensource.org/licenses/MIT
 */
namespace Slim\PDO\Clause;

use Slim\PDO\AbstractClause;

/**
 * Class JoinClause.
 *
 * @author Fabian de Laender <fabian@faapz.nl>
 */
class Join extends AbstractClause
{
    /** @var string $table */
    protected $table;

    /** @var  Conditional $on */
    protected $on;

    /** @var string $type */
    protected $type;

    /**
     * @param string $table
     * @param Conditional $on
     * @param string $type
     */
    public function __construct($table, Conditional $on, $type = "")
    {
        $this->table = $table;
        $this->on = $on;
        $this->type = $type;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return rtrim("{$this->type} JOIN {$this->table} ON {$this->on}");
    }
}
