<?php

/**
 * @license MIT
 * @license http://opensource.org/licenses/MIT
 */

namespace FaaPz\PDO;

use PDO;
use FaaPz\PDO\Statement\Delete;
use FaaPz\PDO\Statement\Insert;
use FaaPz\PDO\Statement\Select;
use FaaPz\PDO\Statement\Update;

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
     * @param string|array<string, string> $table
     *
     * @return Delete
     */
    public function delete($table = null): Delete
    {
        return new Delete($this, $table);
    }

    /**
     * @param array<int|string, mixed> $pairs
     *
     * @return Insert
     */
    public function insert(array $pairs = []): Insert
    {
        return new Insert($this, $pairs);
    }

    /**
     * @param array<int|string, string> $columns
     *
     * @return Select
     */
    public function select(array $columns = ['*']): Select
    {
        return new Select($this, $columns);
    }

    /**
     * @param array<string, mixed> $pairs
     *
     * @return Update
     */
    public function update(array $pairs = []): Update
    {
        return new Update($this, $pairs);
    }
}
