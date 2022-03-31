<?php

namespace Pb\PDO;

use Pb\PDO\Statement\DeleteStatement;
use Pb\PDO\Statement\InsertMultiStatement;
use Pb\PDO\Statement\InsertStatement;
use Pb\PDO\Statement\SelectStatement;
use Pb\PDO\Statement\UpdateStatement;
use PDO;

class Database extends PDO
{
    /**
     * @param string      $dsn
     * @param string|null $usr
     * @param string|null $pwd
     */
    public function __construct($dsn, $usr = null, $pwd = null, array $options = [])
    {
        $options = $options + $this->getDefaultOptions();

        @parent::__construct($dsn, $usr, $pwd, $options);
    }

    /**
     * @return array
     */
    protected function getDefaultOptions()
    {
        return [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false,
            PDO::ATTR_STATEMENT_CLASS => ['Pb\\PDO\\Statement', [$this]],
        ];
    }

    /**
     * @return SelectStatement
     */
    public function select(array $columns = ['*'])
    {
        return new SelectStatement($this, $columns);
    }

    /**
     * @return InsertStatement
     */
    public function insert(array $columnsOrPairs = [])
    {
        return new InsertStatement($this, $columnsOrPairs);
    }

    /**
     * @return InsertMultiStatement
     */
    public function insertMulti(array $keys = [], array $values = [])
    {
        return new InsertMultiStatement($this, $keys, $values);
    }

    /**
     * @return UpdateStatement
     */
    public function update(array $pairs = [])
    {
        return new UpdateStatement($this, $pairs);
    }

    /**
     * @param string $table
     *
     * @return DeleteStatement
     */
    public function delete($table)
    {
        return new DeleteStatement($this, $table);
    }
}
