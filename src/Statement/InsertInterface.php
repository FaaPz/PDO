<?php

/**
 * @license MIT
 * @license http://opensource.org/licenses/MIT
 */

namespace FaaPz\PDO\Statement;

use FaaPz\PDO\StatementInterface;
use FaaPz\PDO\Clause\RawInterface;

interface InsertInterface extends StatementInterface
{
    /**
     * @param string $level
     *
     * @return static
     */
    public function priority(string $level);

    /**
     * @return static
     */
    public function ignore();

    /**
     * @param string $table
     *
     * @return static
     */
    public function into(string $table);

    /**
     * @param string ...$columns
     *
     * @return static
     */
    public function columns(string ...$columns);

    /**
     * @param float|int|string|RawInterface|SelectInterface $value
     * @param float|int|string|RawInterface                 ...$values
     *
     * @return static
     */
    public function values($value, ...$values);

    /**
     * @param array<string, float|int|string|RawInterface> $paris
     *
     * @return static
     */
    public function onDuplicateUpdate(array $paris = []);
}
