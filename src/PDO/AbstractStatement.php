<?php

/**
 * @license MIT
 * @license http://opensource.org/licenses/MIT
 */
namespace Slim\PDO;

use Slim\PDO\Clause\LimitClause;
use Slim\PDO\Clause\OrderClause;
use Slim\PDO\Clause\WhereClause;
use Slim\PDO\Database;

/**
 * Class Statement.
 *
 * @author Fabian de Laender <fabian@faapz.nl>
 */
abstract class AbstractStatement
{
    /**
     * @var Database
     */
    protected $dbh;

    /**
     * @var array
     */
    protected $columns = array();

    /**
     * @var array
     */
    protected $values = array();

    /**
     * @var array
     */
    protected $placeholders = array();

    /**
     * @var
     */
    protected $table;

    /**
     * @var Clause\Conditional[]
     */
    protected $where;

    /**
     * @var string[]
     */
    protected $orderBy;

    /**
     * @var string $limit;
     */
    protected $limit;

    /**
     * Constructor.
     *
     * @param Database $dbh
     */
    public function __construct(Database $dbh)
    {
        $this->dbh = $dbh;

        $this->where = array();
        $this->orderBy = array();
    }


    public function where(AbstractClause $clause) {
        $this->where[] = $clause;
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
     * @param integer|null $count
     * @param integer|null $start
     *
     * @return $this
     */
    public function limit($count, $start = null)
    {
        $this->limit = $count;
        if  ($start === null) {
            $this->limit .= ", {$start}";
        }

        return $this;
    }

    /**
     * @return mixed
     */
    abstract public function __toString();

    /**
     * @return \PDOStatement
     */
    public function execute()
    {
        $stmt = $this->getStatement();
        $stmt->execute($this->values);

        return $stmt;
    }

    /**
     * @return string
     */
    public function compile()
    {
        return $this->getStatement()->queryString;
    }

    /**
     * @param $table
     *
     * @return $this
     */
    protected function setTable($table)
    {
        $this->table = $table;

        return $this;
    }

    /**
     * @param array $columns
     *
     * @return $this
     */
    protected function setColumns(array $columns)
    {
        $this->columns = array_merge($this->columns, $columns);

        return $this;
    }

    /**
     * @param array $values
     *
     * @return $this
     */
    protected function setValues(array $values)
    {
        $this->values = array_merge($this->values, $values);

        return $this;
    }

    /**
     * @return string
     */
    protected function getPlaceholders()
    {
        $placeholders = $this->placeholders;

        unset($this->placeholders);

        return '( '.implode(' , ', $placeholders).' )';
    }

    /**
     * @param array $values
     */
    protected function setPlaceholders(array $values)
    {
        foreach ($values as $value) {
            $this->placeholders[] = $this->setPlaceholder('?', is_null($value) ? 1 : sizeof($value));
        }
    }

    /**
     * @return \PDOStatement
     */
    private function getStatement()
    {
        $sql = $this;

        return $this->dbh->prepare($sql);
    }

    /**
     * @param $text
     * @param int    $count
     * @param string $separator
     *
     * @return string
     */
    private function setPlaceholder($text, $count = 0, $separator = ' , ')
    {
        $result = array();

        if ($count > 0) {
            for ($x = 0; $x < $count; ++$x) {
                $result[] = $text;
            }
        }

        return implode($separator, $result);
    }
}
