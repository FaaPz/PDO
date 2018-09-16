<?php

namespace Pb\PDO;

use PDO;
use Pb\PDO\Statement\SelectStatement;
use Pb\PDO\Statement\InsertStatement;
use Pb\PDO\Statement\UpdateStatement;
use Pb\PDO\Statement\DeleteStatement;
use Pb\PDO\Statement\InsertMultiStatement;

class Database extends PDO
{
    /**
     * @param string $dsn
     * @param null   $usr
     * @param null   $pwd
     * @param array  $options
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

    public function select(array $columns = ['*'])
    {
        return new SelectStatement($this, $columns);
    }

    public function insert(array $columnsOrPairs = [])
    {
        return new InsertStatement($this, $columnsOrPairs);
    }

    public function insertMulti(array $keys = [], array $values = [])
    {
        return new InsertMultiStatement($this, $keys, $values);
    }

    public function update(array $pairs = [])
    {
        return new UpdateStatement($this, $pairs);
    }

    public function delete($table = null)
    {
        return new DeleteStatement($this, $table);
    }
}
