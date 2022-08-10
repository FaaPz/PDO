<?php

/**
 * @license MIT
 * @license http://opensource.org/licenses/MIT
 */

namespace FaaPz\PDO;

use FaaPz\PDO\Clause\ConditionalInterface;
use FaaPz\PDO\Clause\JoinInterface;
use FaaPz\PDO\Clause\LimitInterface;

interface AdvancedStatementInterface extends StatementInterface
{
    /**
     * @param JoinInterface $clause
     *
     * @return self
     */
    public function join(JoinInterface $clause);

    /**
     * @param ConditionalInterface $clause
     *
     * @return self
     */
    public function where(ConditionalInterface $clause);

    /**
     * @param string $column
     * @param string $direction
     *
     * @return self
     */
    public function orderBy(string $column, string $direction = '');

    /**
     * @param LimitInterface $limit
     *
     * @return self
     */
    public function limit(LimitInterface $limit);
}
