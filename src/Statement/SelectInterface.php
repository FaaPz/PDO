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
     * @return static
     */
    public function distinct();

    /**
     * @param array<int|string, string|SelectInterface> $columns
     *
     * @return static
     */
    public function columns(array $columns = ['*']);

    /**
     * @param string|array<string, string|SelectInterface> $table
     *
     * @return static
     */
    public function from($table);

    /**
     * @param SelectInterface $query
     *
     * @return static
     */
    public function union(SelectInterface $query);

    /**
     * @param SelectInterface $query
     *
     * @return static
     */
    public function unionAll(SelectInterface $query);

    /**
     * @param string ...$columns
     *
     * @return static
     */
    public function groupBy(string ...$columns);

    /**
     * @param ConditionalInterface $clause
     *
     * @return static
     */
    public function having(ConditionalInterface $clause);
}
