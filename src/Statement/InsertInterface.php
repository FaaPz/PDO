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
     * @return self
     */
    public function priority(string $level);

    /**
     * @return self
     */
    public function ignore();

    /**
     * @param string $table
     *
     * @return self
     */
    public function into(string $table);

    /**
     * @param string ...$columns
     *
     * @return self
     */
    public function columns(string ...$columns);

    /**
     * @param float|int|string|RawInterface|SelectInterface $value
     * @param float|int|string|RawInterface                 ...$values
     *
     * @return self
     */
    public function values($value, ...$values);

    /**
     * @param array<string, float|int|string|RawInterface> $paris
     *
     * @return self
     */
    public function onDuplicateUpdate(array $paris = []);
}
