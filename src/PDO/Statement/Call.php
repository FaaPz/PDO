<?php

/**
 * @license MIT
 * @license http://opensource.org/licenses/MIT
 */

namespace Slim\PDO\Statement;

use PDO;
use Slim\PDO\AbstractStatement;
use Slim\PDO\Clause;

class Call extends AbstractStatement
{
    /** @var Clause\Method $table */
    protected $table;

    /**
     * @param PDO           $dbh
     * @param Clause\Method $procedure
     */
    public function __construct(PDO $dbh, Clause\Method $procedure = null)
    {
        parent::__construct($dbh);

        $this->table = $procedure;
    }

	/**
	 * @param Clause\Method $procedure
	 *
	 * @return $this
	 */
    public function method(Clause\Method $procedure)
    {
        $this->table = $procedure;

        return $this;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        if (!isset($this->table)) {
            trigger_error('No method is set for stored procedure call', E_USER_ERROR);
        }

        $sql = "CALL {$this->table};";

        return $sql;
    }

    /**
     * @return array
     */
    public function getValues()
    {
        return $this->table->getValues();
    }
}
