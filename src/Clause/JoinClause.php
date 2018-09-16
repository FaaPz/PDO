<?php

namespace Pb\PDO\Clause;

class JoinClause extends ClauseContainer
{
    /**
     * @param string $table
     * @param string $first
     * @param null   $operator
     * @param null   $second
     * @param string $joinType
     */
    public function join($table, $first, $operator = null, $second = null, $joinType = 'INNER')
    {
        $this->container[] = ' '.$joinType.' JOIN '.$table.' ON '.$first.' '.$operator.' '.$second;
    }

    /**
     * @param string $table
     * @param string $first
     * @param null   $operator
     * @param null   $second
     */
    public function leftJoin($table, $first, $operator = null, $second = null)
    {
        $this->join($table, $first, $operator, $second, 'LEFT OUTER');
    }

    /**
     * @param string $table
     * @param string $first
     * @param null   $operator
     * @param null   $second
     */
    public function rightJoin($table, $first, $operator = null, $second = null)
    {
        $this->join($table, $first, $operator, $second, 'RIGHT OUTER');
    }

    /**
     * @param string $table
     * @param string $first
     * @param null   $operator
     * @param null   $second
     */
    public function fullJoin($table, $first, $operator = null, $second = null)
    {
        $this->join($table, $first, $operator, $second, 'FULL OUTER');
    }

    /**
     * @return string
     */
    public function __toString()
    {
        if (empty($this->container)) {
            return '';
        }

        $args = [];

        foreach ($this->container as $join) {
            $args[] = $join;
        }

        return implode('', $args);
    }
}
