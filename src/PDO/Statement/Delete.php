<?php

/**
 * @license MIT
 * @license http://opensource.org/licenses/MIT
 */
namespace Slim\PDO\Statement;

use Slim\PDO\AbstractStatement;
use Slim\PDO\Database;

/**
 * Class DeleteStatement.
 *
 * @author Fabian de Laender <fabian@faapz.nl>
 */
class Delete extends AbstractStatement
{
    /**
     * Constructor.
     *
     * @param Database $dbh
     * @param $table
     */
    public function __construct(Database $dbh, $table = null)
    {
        parent::__construct($dbh);

        $this->setTable($table);
    }

    /**
     * @param $table
     *
     * @return $this
     */
    public function from($table)
    {
        $this->table = $table;

        return $this;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        if (empty($this->table)) {
            trigger_error("No table is set for deletion", E_USER_ERROR);
        }

        $sql = "DELETE FROM {$this->table}";
        if (isset($this->where)) {
            $sql .= " WHERE {$this->where}";
        }

        if (count($this->orderBy) > 0) {
            $sql .= " ORDER BY " . implode(", ", $this->orderBy);
        }

        if ($this->limit != null) {
            $sql .= " LIMIT {$this->limit}";
        }

        return $sql;
    }

    /**
     * @return int
     */
    public function execute()
    {
        return parent::execute()->rowCount();
    }
}
