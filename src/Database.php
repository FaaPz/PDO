<?php

/**
 * @license MIT
 * @license http://opensource.org/licenses/MIT
 */

namespace FaaPz\PDO;

use FaaPz\PDO\Statement\DeleteStatement;
use FaaPz\PDO\Statement\DropStatement;
use FaaPz\PDO\Statement\InsertStatement;
use FaaPz\PDO\Statement\SelectStatement;
use FaaPz\PDO\Statement\TruncateStatement;
use FaaPz\PDO\Statement\UpdateStatement;

/**
 * Class Database.
 *
 * @author Fabian de Laender <fabian@faapz.nl>
 */
class Database extends \PDO
{
    /**
     * Constructor.
     *
     * @param $dsn
     * @param null  $usr
     * @param null  $pwd
     * @param array $options
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
            \PDO::ATTR_ERRMODE              => \PDO::ERRMODE_EXCEPTION,
            \PDO::ATTR_DEFAULT_FETCH_MODE   => \PDO::FETCH_ASSOC,
            \PDO::ATTR_EMULATE_PREPARES     => false,
            \PDO::ATTR_STATEMENT_CLASS      => [Statement::class, [$this]],
        ];
    }

    /**
     * @param array $columns
     *
     * @return SelectStatement
     */
    public function select(array $columns = ['*'])
    {
        return new SelectStatement($this, $columns);
    }

    /**
     * @param array $columnsOrPairs
     *
     * @return InsertStatement
     */
    public function insert(array $columnsOrPairs = [])
    {
        return new InsertStatement($this, $columnsOrPairs);
    }

    /**
     * @param array $pairs
     *
     * @return UpdateStatement
     */
    public function update(array $pairs = [])
    {
        return new UpdateStatement($this, $pairs);
    }

    /**
     * @param null $table
     *
     * @return DeleteStatement
     */
    public function delete($table = null)
    {
        return new DeleteStatement($this, $table);
    }

    /**
     * @param null $table
     *
     * @return TruncateStatement
     */
    public function truncate($table = null)
    {
        return new TruncateStatement($this, $table);
    }

    /**
     * @param null $table
     *
     * @return DropStatement
     */
    public function drop($table = null)
    {
        return new DropStatement($this, $table);
    }
}
