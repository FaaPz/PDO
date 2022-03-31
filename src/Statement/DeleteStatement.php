<?php

namespace Pb\PDO\Statement;

use Pb\PDO\Database;

class DeleteStatement extends StatementContainer
{
    /**
     * @param string   $table
     */
    public function __construct(Database $dbh, $table)
    {
        parent::__construct($dbh);

        $this->setTable($table);
    }

    /**
     * @param string $table
     *
     * @return self
     */
    public function from($table)
    {
        $this->setTable($table);

        return $this;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        if (empty($this->table)) {
            trigger_error('No table is set for deletion', E_USER_ERROR);
        }

        $sql = 'DELETE FROM '.$this->table;
        $sql .= $this->whereClause;
        $sql .= $this->orderClause;
        $sql .= $this->limitClause;

        return $sql;
    }

    /**
     * @return int
     */
    public function execute()
    {
        return $this->executeStmt()->rowCount();
    }
}
