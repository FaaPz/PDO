<?php

/**
 * @license MIT
 * @license http://opensource.org/licenses/MIT
 */
namespace Slim\PDO;

use PDOStatement;

abstract class AbstractStatement implements StatementInterface
{
    /** @var Database $dbh */
    protected $dbh;

    /** @var string $table */
    protected $table;

    /** @var Clause\Conditional|null $where */
    protected $where = null;

    /** @var string[] $orderBy */
    protected $orderBy = array();

    /** @var Clause\Limit|null $limit */
    protected $limit = null;

    /**
     * @param Database $dbh
     */
    public function __construct(Database $dbh)
    {
        $this->dbh = $dbh;
    }

    /**
     * @param Clause\Conditional $clause
     * @return $this
     */
    public function where(Clause\Conditional $clause) {
        $this->where = $clause;

        return $this;
    }

    /**
     * @param string $column
     * @param string $direction
     * @return $this
     */
    public function orderBy($column, $direction = null)
    {
        $this->orderBy[] = rtrim("{$column} {$direction}");

        return $this;
    }

    /**
     * @param Clause\Limit|null $limit
     * @return $this
     */
    public function limit(Clause\Limit $limit)
    {
        $this->limit = $limit;

        return $this;
    }

    /**
     * @return array
     */
    abstract public function getValues();

    /**
     * @return string
     */
    abstract public function __toString();

    /**
     * @return PDOStatement
     */
    public function execute()
    {
        $stmt = $this->dbh->prepare($this->__toString());
        $stmt->execute($this->getValues());

        return $stmt;
    }

    /**
     * @param string $table
     */
    protected function setTable($table)
    {
        $this->table = $table;
    }
}
