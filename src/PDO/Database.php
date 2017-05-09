<?php

/**
 * @license MIT
 * @license http://opensource.org/licenses/MIT
 */
namespace Slim\PDO;

use Slim\PDO\Statement;
use PDO;

class Database extends PDO
{
    /**
     * @param string $dsn
     * @param string|null $username
     * @param string|null $password
     * @param array $options
     */
    public function __construct($dsn, $username = null, $password = null, array $options = array())
    {
        $options = $this->getDefaultOptions() + $options;

        parent::__construct($dsn, $username, $password, $options);
    }

    /**
     * @return array
     */
    protected function getDefaultOptions()
    {
        return array(
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES => false
        );
    }

    /**
     * @param array $columns
     *
     * @return Statement\Select
     */
    public function select(array $columns = array('*'))
    {
        return new Statement\Select($this, $columns);
    }

    /**
     * @param array $columns
     *
     * @return Statement\Insert
     */
    public function insert(array $columns = array())
    {
        return new Statement\Insert($this, $columns);
    }

    /**
     * @param array $pairs
     *
     * @return Statement\Update
     */
    public function update(array $pairs = array())
    {
        return new Statement\Update($this, $pairs);
    }

    /**
     * @param string|null $table
     * @return Statement\Delete
     */
    public function delete($table = null)
    {
        return new Statement\Delete($this, $table);
    }
}
