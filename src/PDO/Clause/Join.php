<?php

/**
 * @license MIT
 * @license http://opensource.org/licenses/MIT
 */
namespace Slim\PDO\Clause;

use Slim\PDO\StatementInterface;

class Join implements StatementInterface
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

    public function getValues()
    {
        return $this->on->getValues();
    }

    /**
     * @return string
     */
    public function __toString()
    {
        return ltrim("{$this->type} JOIN {$this->table} ON {$this->on}");
    }
}
