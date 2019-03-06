<?php

/**
 * @license MIT
 * @license http://opensource.org/licenses/MIT
 */

namespace FaaPz\PDO;

abstract class AdvancedStatement extends AbstractStatement
{
    /** @var Clause\Join[] */
    protected $join = [];

    /** @var Clause\Conditional|Clause\Grouping|null $where */
    protected $where = null;

    /** @var string[] $orderBy */
    protected $orderBy = [];

    /** @var Clause\Limit|null $limit */
    protected $limit = null;

    /**
     * @param Clause\Join|Clause\Join[] $clause
     *
     * @return $this
     */
    public function join(Clause\Join $clause)
    {
        if (is_array($clause)) {
            $this->join = array_merge($this->join[], array_values($clause));
        } else {
            $this->join[] = $clause;
        }

        return $this;
    }

    /**
     * @param Clause\Conditional|Clause\Grouping $clause
     *
     * @return $this
     */
    public function where($clause)
    {
        $this->where = $clause;

        return $this;
    }

    /**
     * @param string $column
     * @param string $direction
     *
     * @return $this
     */
    public function orderBy($column, $direction = null)
    {
        $this->orderBy[] = rtrim("{$column} {$direction}");

        return $this;
    }

    /**
     * @param Clause\Limit|null $limit
     *
     * @return $this
     */
    public function limit(Clause\Limit $limit)
    {
        $this->limit = $limit;

        return $this;
    }
}
