<?php

namespace Pb\PDO\Clause;

class GroupClause extends ClauseContainer
{
    /**
     * @param mixed $columns
     *
     * @return void
     */
    public function groupBy($columns)
    {
        if (is_array($columns)) {
            $this->container += $columns;
        } else {
            $this->container[] = $columns;
        }
    }

    /**
     * @return string
     */
    public function __toString()
    {
        if (empty($this->container)) {
            return '';
        }

        return ' GROUP BY '.implode(' , ', $this->container);
    }
}
