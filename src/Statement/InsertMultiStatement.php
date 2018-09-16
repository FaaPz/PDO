<?php

namespace Pb\PDO\Statement;

use Pb\PDO\Database;

class InsertMultiStatement extends StatementContainer
{
    protected $updateOnDuplicate = [];

    public function __construct(Database $dbh, array $keys, array $values)
    {
        parent::__construct($dbh);

        $this->columns($keys);

        $this->values($values);
    }

    /**
     * @param string $table
     */
    public function into($table)
    {
        $this->setTable($table);

        return $this;
    }

    public function columns(array $columns)
    {
        $this->setColumns($columns);

        return $this;
    }

    public function values(array $values)
    {
        $this->setValues($values);

        foreach ($values as $row) {
            $this->setMultiPlaceholders($row);
        }

        return $this;
    }

    public function addRow(array $values)
    {
        $this->appendValues($values);

        $this->setMultiPlaceholders($values);

        return $this;
    }

    public function onDuplicateKeyUpdate(array $keys)
    {
        $this->updateOnDuplicate = $keys;

        return $this;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        if (empty($this->table)) {
            trigger_error('No table is set for insertion', E_USER_ERROR);
        }

        if (empty($this->columns)) {
            trigger_error('Missing columns for insertion', E_USER_ERROR);
        }

        if (empty($this->values)) {
            trigger_error('Missing values for insertion', E_USER_ERROR);
        }

        $sql = 'INSERT INTO '.$this->table;
        $sql .= ' '.$this->getColumns();
        $sql .= ' VALUES '.$this->getPlaceholdersMulti();

        if (! empty($this->updateOnDuplicate)) {
            $sql .= ' ON DUPLICATE KEY UPDATE '.$this->getOnDuplicates();
        }

        return $sql;
    }

    /**
     * @return int
     */
    public function execute()
    {
        $stmt = parent::executeMulti();

        return $stmt->rowCount();
    }

    /**
     * @return string
     */
    protected function getColumns()
    {
        return '( `'.implode('` , `', $this->columns).'` )';
    }

    /**
     * @return string
     */
    protected function getOnDuplicates()
    {
        $updates = [];

        foreach ($this->updateOnDuplicate as $key) {
            $updates[] = '`'.$key.'` = VALUES( `'.$key.'` )';
        }

        return implode(' , ', $updates);
    }
}
