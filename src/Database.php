<?php

/**
 * @license MIT
 * @license http://opensource.org/licenses/MIT
 */

namespace FaaPz\PDO;

use PDO;

class Database extends PDO
{
    /**
     * @param string            $dsn
     * @param string|null       $username
     * @param string|null       $password
     * @param array<int, mixed> $options
     *
     * @codeCoverageIgnore
     */
    public function __construct(string $dsn, string $username = null, string $password = null, array $options = [])
    {
        parent::__construct($dsn, $username, $password, $options + $this->getDefaultOptions());
    }

    /**
     * @codeCoverageIgnore
     *
     * @return array<int, mixed>
     */
    protected function getDefaultOptions(): array
    {
        return [
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
        ];
    }

    /**
     * @param array<int|string, string> $columns
     *
     * @return Statement\Select
     */
    public function select(array $columns = ['*']): Statement\Select
    {
        return new Statement\Select($this, $columns);
    }

    /**
     * @param array<int|string, mixed> $pairs
     *
     * @return Statement\Insert
     */
    public function insert(array $pairs = []): Statement\Insert
    {
        return new Statement\Insert($this, $pairs);
    }

    /**
     * @param array<string, mixed> $pairs
     *
     * @return Statement\Update
     */
    public function update(array $pairs = []): Statement\Update
    {
        return new Statement\Update($this, $pairs);
    }

    /**
     * @param string|array<string, string> $table
     *
     * @return Statement\Delete
     */
    public function delete($table = null): Statement\Delete
    {
        return new Statement\Delete($this, $table);
    }
}
