<?php

/**
 * @license MIT
 * @license http://opensource.org/licenses/MIT
 */

namespace FaaPz\PDO\Clause;

use FaaPz\PDO\DatabaseException;
use FaaPz\PDO\QueryInterface;
use FaaPz\PDO\Statement\Select;

class Join implements QueryInterface
{
    /** @var string|array<string,string|Select> $subject */
    protected $subject;

    /** @var Conditional $on */
    protected $on;

    /** @var string $type */
    protected $type;

    /**
     * @param string|array<string,string|Select> $subject
     * @param Conditional                        $on
     * @param string                             $type
     */
    public function __construct($subject, Conditional $on, string $type = '')
    {
        $this->subject = $subject;
        $this->on = $on;
        $this->type = strtoupper(trim($type));
    }

    /**
     * @return mixed[]
     */
    public function getValues(): array
    {
        return $this->on->getValues();
    }

    /**
     * @return string
     * @throws DatabaseException
     */
    public function __toString(): string
    {
        $table = $this->subject;
        if (is_array($this->subject)) {
            reset($this->subject);
            $alias = key($this->subject);
            if (!is_string($alias)) {
                throw new DatabaseException('Invalid subject array, use string keys for alias');
            }

            $table = $this->subject[$alias];
            if ($table instanceof Select) {
                $table = "({$table})";
            }
            $table .= " AS {$alias}";
        } elseif (!is_string($this->subject)) {
            throw new DatabaseException('Invalid subject value, use array with string key for alias');
        }

        $sql = "JOIN {$table} ON {$this->on}";
        if (!empty($this->type)) {
            $sql = "{$this->type} {$sql}";
        }

        return $sql;
    }
}
