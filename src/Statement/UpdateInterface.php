<?php

/**
 * @license MIT
 * @license http://opensource.org/licenses/MIT
 */

namespace FaaPz\PDO\Statement;

use FaaPz\PDO\StatementInterface;

interface UpdateInterface extends StatementInterface
{
    /**
     * @param string $table
     *
     * @return self
     */
    public function table(string $table);

    /**
     * @param string $column
     * @param mixed  $value
     *
     * @return self
     */
    public function set(string $column, $value);

    /**
     * @param array<string, mixed> $pairs
     *
     * @return self
     */
    public function pairs(array $pairs);
}
