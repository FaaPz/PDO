<?php

/**
 * @license MIT
 * @license http://opensource.org/licenses/MIT
 */

namespace FaaPz\PDO\Statement;

use FaaPz\PDO\AdvancedStatementInterface;
use FaaPz\PDO\Clause\RawInterface;

interface UpdateInterface extends AdvancedStatementInterface
{
    /**
     * @param string $table
     *
     * @return static
     */
    public function table(string $table);

    /**
     * @param string                                        $column
     * @param float|int|string|RawInterface|SelectInterface $value
     *
     * @return static
     */
    public function set(string $column, $value);

    /**
     * @param array<string, float|int|string|RawInterface|SelectInterface> $pairs
     *
     * @return static
     */
    public function pairs(array $pairs);
}
