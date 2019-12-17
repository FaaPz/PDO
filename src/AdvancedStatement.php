<?php

/**
 * @license MIT
 * @license http://opensource.org/licenses/MIT
 */

declare(strict_types=1);

namespace FaaPz\PDO;

abstract class AdvancedStatement extends AbstractStatement
{
    /** @var Clause\Join[] $join */
    protected $join = [];

    /** @var Clause\Conditional $where */
    protected $where = null;

    /** @var string[] $orderBy */
    protected $orderBy = [];

    /** @var Clause\Limit $limit */
    protected $limit = null;

    /**
     * @param Clause\Join $clause
     *
     * @return $this
     */
    public function join(Clause\Join $clause)
    {
        $this->join[] = $clause;

        return $this;
    }

    /**
     * @param Clause\Conditional $clause
     *
     * @return $this
     */
    public function where(Clause\Conditional $clause)
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
    public function orderBy(string $column, string $direction = '')
    {
        $this->orderBy[$column] = $direction;

        return $this;
    }

    /**
     * @param Clause\Limit|null $limit
     *
     * @return $this
     */
    public function limit(?Clause\Limit $limit)
    {
        $this->limit = $limit;

        return $this;
    }
}
