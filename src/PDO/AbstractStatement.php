<?php

/**
 * @license MIT
 * @license http://opensource.org/licenses/MIT
 */

namespace Slim\PDO;

use PDO;
use PDOException;
use PDOStatement;

abstract class AbstractStatement implements StatementInterface
{
    /** @var PDO $dbh */
    protected $dbh;

    /** @var string $table */
    protected $table;

    /** @var Clause\Conditional|null $where */
    protected $where = null;

    /** @var string[] $orderBy */
    protected $orderBy = [];

    /** @var Clause\Limit|null $limit */
    protected $limit = null;

    /**
     * @param PDO $dbh
     */
    public function __construct(PDO $dbh)
    {
        $this->dbh = $dbh;
    }

    /**
     * @param Clause\Conditional $clause
     *
     * @return $this
     */
    public function where(Clause\Conditional $clause)
    {
        $this->where = $clause;

        return $this;
    }

    /**
     * @param string $column
     * @param string $direction
     *
     * @return $this
     */
    public function orderBy($column, $direction = null)
    {
        $this->orderBy[] = rtrim("{$column} {$direction}");

        return $this;
    }

    /**
     * @param Clause\Limit|null $limit
     *
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
     * @throws PDOException
     *
     * @return PDOStatement
     */
    public function execute()
    {
        $stmt = $this->dbh->prepare($this->__toString());

        try {
            $success = $stmt->execute($this->getValues());
            if (!$success) {
                $info = $stmt->errorInfo();

                throw new Exception($info[2], $info[0]);
            }
        } catch (PDOException $e) {
            throw new Exception($e->getMessage(), $e->getCode(), $e);
        }

        return $stmt;
    }
}
