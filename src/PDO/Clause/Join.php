<?php

/**
 * @license MIT
 * @license http://opensource.org/licenses/MIT
 */

namespace Slim\PDO\Clause;

use Slim\PDO\Statement\Select;
use Slim\PDO\StatementInterface;

class Join implements StatementInterface
{
    /** @var string|string[string]|Select|Select[string] $table */
    protected $table;

    /** @var Conditional|Grouping $on */
    protected $on;

    /** @var string $type */
    protected $type;

    /**
     * @param string|string[string]|Select|Select[string] $table
     * @param Conditional|Grouping                        $on
     * @param string                                      $type
     */
    public function __construct($table, $on, $type = '')
    {
        $this->table = $table;
        $this->on = $on;
        $this->type = $type;
    }

    /**
     * @return array
     */
    public function getValues()
    {
        return $this->on->getValues();
    }

    /**
     * @return string
     */
    public function __toString()
    {
        $table = $this->table;
        if (is_array($this->table)) {
            $alias = array_key_first($this->table);

            if ($this->table[$alias] instanceof Select) {
                $table = "({$this->table[$alias]})";
            } else {
                $table = $this->table[$alias];
            }

            if (is_string($alias)) {
                $table .= " AS {$alias}";
            }
        }

        return ltrim("{$this->type} JOIN {$table} ON {$this->on}");
    }
}
