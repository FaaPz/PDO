<?php

/**
 * @license MIT
 * @license http://opensource.org/licenses/MIT
 */

namespace FaaPz\PDO;

use FaaPz\PDO\Statement\SelectStatement;
use FaaPz\PDO\Statement\InsertStatement;
use FaaPz\PDO\Statement\UpdateStatement;
use FaaPz\PDO\Statement\DeleteStatement;

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
    public function __construct($dsn, $usr = null, $pwd = null, array $options = array())
    {
        $options = $options + $this->getDefaultOptions();

        @parent::__construct($dsn, $usr, $pwd, $options);
    }

    /**
     * @return array
     */
    protected function getDefaultOptions()
    {
        return array(
            \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,
            \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,
            \PDO::ATTR_EMULATE_PREPARES => false,
            \PDO::ATTR_STATEMENT_CLASS => array('FaaPz\\PDO\\Statement', array($this)),
        );
    }

    /**
     * @param array $columns
     *
     * @return SelectStatement
     */
    public function select(array $columns = array('*'))
    {
        return new SelectStatement($this, $columns);
    }

    /**
     * @param array $columnsOrPairs
     *
     * @return InsertStatement
     */
    public function insert(array $columnsOrPairs = array())
    {
        return new InsertStatement($this, $columnsOrPairs);
    }

    /**
     * @param array $pairs
     *
     * @return UpdateStatement
     */
    public function update(array $pairs = array())
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
}
