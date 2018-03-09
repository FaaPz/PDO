<?php

/**
 * @license MIT
 * @license http://opensource.org/licenses/MIT
 */

namespace Slim\PDO;

use PDO;

class Database extends PDO
{
    /**
     * @param string      $dsn
     * @param string|null $username
     * @param string|null $password
     * @param array       $options
     */
    public function __construct($dsn, $username = null, $password = null, array $options = [])
    {
        $options = $options + $this->getDefaultOptions();

        parent::__construct($dsn, $username, $password, $options);
    }

    /**
     * @return array
     */
    protected function getDefaultOptions()
    {
        return array(
            PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            PDO::ATTR_EMULATE_PREPARES   => false,
		);
    }

	/**
	 * @param Clause\Method $procedure
	 *
	 * @return Statement\Call
	 */
	public function call(Clause\Method $procedure = null)
	{
		return new Statement\Call($this, $procedure);
	}

    /**
     * @param array $columns
     *
     * @return Statement\Select
     */
    public function select(array $columns = ['*'])
    {
        return new Statement\Select($this, $columns);
    }

    /**
     * @param array $columns
     *
     * @return Statement\Insert
     */
    public function insert(array $columns = [])
    {
        return new Statement\Insert($this, $columns);
    }

    /**
     * @param array $pairs
     *
     * @return Statement\Update
     */
    public function update(array $pairs = [])
    {
        return new Statement\Update($this, $pairs);
    }

    /**
     * @param string|null $table
     *
     * @return Statement\Delete
     */
    public function delete($table = null)
    {
        return new Statement\Delete($this, $table);
    }
}
