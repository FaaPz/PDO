<?php

/**
 * @license MIT
 * @license http://opensource.org/licenses/MIT
 */

namespace FaaPz\PDO;

use FaaPz\PDO\Clause\MethodInterface;
use FaaPz\PDO\Statement\CallInterface;
use FaaPz\PDO\Statement\Call;
use FaaPz\PDO\Statement\Delete;
use FaaPz\PDO\Statement\DeleteInterface;
use FaaPz\PDO\Statement\Insert;
use FaaPz\PDO\Statement\InsertInterface;
use FaaPz\PDO\Statement\Select;
use FaaPz\PDO\Statement\SelectInterface;
use FaaPz\PDO\Statement\Update;
use FaaPz\PDO\Statement\UpdateInterface;
use PDO;

class Database extends PDO implements DatabaseInterface
{
    /**
     * @param string            $dsn
     * @param string|null       $username
     * @param string|null       $password
     * @param array<int, mixed> $options
     *
     * @codeCoverageIgnore
     */
    public function __construct(string $dsn, ?string $username = null, ?string $password = null, array $options = [])
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
     * @param ?MethodInterface $procedure
     *
     * @return CallInterface
     */
    public function call(?MethodInterface $procedure = null): CallInterface
    {
        return new Call($this, $procedure);
    }

    /**
     * @param array<int|string, mixed> $pairs
     *
     * @return InsertInterface
     */
    public function insert(array $pairs = []): InsertInterface
    {
        return new Insert($this, $pairs);
    }

    /**
     * @param array<int|string, string> $columns
     *
     * @return SelectInterface
     */
    public function select(array $columns = ['*']): SelectInterface
    {
        return new Select($this, $columns);
    }

    /**
     * @param array<string, mixed> $pairs
     *
     * @return UpdateInterface
     */
    public function update(array $pairs = []): UpdateInterface
    {
        return new Update($this, $pairs);
    }

    /**
     * @param ?string|?array<string, string> $table
     *
     * @return DeleteInterface
     */
    public function delete($table = null): DeleteInterface
    {
        return new Delete($this, $table);
    }
}
