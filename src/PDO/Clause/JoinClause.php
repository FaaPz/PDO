<?php

/**
 * @license MIT
 * @license http://opensource.org/licenses/MIT
 */
namespace Slim\PDO\Clause;

/**
 * Class JoinClause.
 *
 * @author Fabian de Laender <fabian@faapz.nl>
 */
class JoinClause extends ClauseContainer
{
    /**
     * @param $table
     * @param $first
     * @param null   $operator
     * @param null   $second
     * @param string $type
     */
    public function join($table, $first, $operator = null, $second = null, $type = 'INNER')
    {
        $this->container[] = ' '.$type.' JOIN '.$table.' ON '.$first.' '.$operator.' '.$second;
    }

    /**
     * @param $table
     * @param $first
     * @param null $operator
     * @param null $second
     */
    public function leftJoin($table, $first, $operator = null, $second = null)
    {
        $this->join($table, $first, $operator, $second, 'LEFT OUTER');
    }

    /**
     * @param $table
     * @param $first
     * @param null $operator
     * @param null $second
     */
    public function rightJoin($table, $first, $operator = null, $second = null)
    {
        $this->join($table, $first, $operator, $second, 'RIGHT OUTER');
    }

    /**
     * @param $table
     * @param $first
     * @param null $operator
     * @param null $second
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

        $args = array();

        foreach ($this->container as $join) {
            $args[] = $join;
        }

        return implode('', $args);
    }
}
