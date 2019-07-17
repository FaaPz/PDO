<?php


namespace FaaPz\PDO\Statement;


use FaaPz\PDO\Database;

class TruncateStatement extends StatementContainer
{
    /**
     * Constructor.
     *
     * @param Database $dbh
     */
    public function __construct(Database $dbh, $table)
    {
        parent::__construct($dbh);

        $this->setTable($table);
    }

    /**
     * @return string
     */
    public function __toString()
    {
        if (empty($this->table)) {
            trigger_error('No table is set for selection', E_USER_ERROR);
        }

        $sql = $this->getTruncate().' '.$this->table;

        return $sql;
    }

    protected function getTruncate()
    {
        return 'TRUNCATE';
    }

    /**
     * @return \PDOStatement
     */
    public function execute()
    {
        return parent::execute();
    }
}
