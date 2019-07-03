<?php

/**
 * @license MIT
 * @license http://opensource.org/licenses/MIT
 */

namespace FaaPz\PDO\Statement;

use FaaPz\PDO\AbstractStatement;
use FaaPz\PDO\Clause;
use FaaPz\PDO\DatabaseException;
use PDO;

class Call extends AbstractStatement
{
    /** @var Clause\Method $method */
    protected $method;

    /**
     * @param PDO           $dbh
     * @param Clause\Method $procedure
     */
    public function __construct(PDO $dbh, Clause\Method $procedure = null)
    {
        parent::__construct($dbh);

        $this->method = $procedure;
    }

    /**
     * @param Clause\Method $procedure
     *
     * @return $this
     */
    public function method(Clause\Method $procedure)
    {
        $this->method = $procedure;

        return $this;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        if (!isset($this->method)) {
            throw new DatabaseException('No method is set for stored procedure call');
        }

        $sql = "CALL {$this->method};";

        return $sql;
    }

    /**
     * @return array
     */
    public function getValues()
    {
        return $this->method->getValues();
    }
}
