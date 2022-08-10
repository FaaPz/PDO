<?php

/**
 * @license MIT
 * @license http://opensource.org/licenses/MIT
 */

namespace FaaPz\PDO\Statement;

use FaaPz\PDO\AdvancedStatementInterface;
use FaaPz\PDO\Clause\ConditionalInterface;

interface SelectInterface extends AdvancedStatementInterface
{
    /**
     * @return self
     */
    public function distinct();

    /**
     * @param array<int|string, string|SelectInterface> $columns
     *
     * @return self
     */
    public function columns(array $columns = ['*']);

    /**
     * @param string|array<string, string|SelectInterface> $table
     *
     * @return self
     */
    public function from($table);

    /**
     * @param SelectInterface $query
     *
     * @return self
     */
    public function union(SelectInterface $query);

    /**
     * @param SelectInterface $query
     *
     * @return self
     */
    public function unionAll(SelectInterface $query);

    /**
     * @param string ...$columns
     *
     * @return self
     */
    public function groupBy(string ...$columns);

    /**
     * @param ConditionalInterface $clause
     *
     * @return self
     */
    public function having(ConditionalInterface $clause);
}
