<?php

namespace Pb\PDO\Clause;

class OrderClause extends ClauseContainer
{
    /**
     * @param string $column
     * @param string $direction
     *
     * @return void
     */
    public function orderBy($column, $direction = 'ASC')
    {
        $this->container[] = $column.' '.strtoupper($direction);
    }

    /**
     * @return string
     */
    public function __toString()
    {
        if (empty($this->container)) {
            return '';
        }

        return ' ORDER BY '.implode(' , ', $this->container);
    }
}
