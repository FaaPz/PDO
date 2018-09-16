<?php

namespace Pb\PDO\Clause;

class GroupClause extends ClauseContainer
{
    public function groupBy(array $columns)
    {
        $this->container += $columns;
    }

    public function __toString()
    {
        if (empty($this->container)) {
            return '';
        }

        return ' GROUP BY '.implode(' , ', $this->container);
    }
}
