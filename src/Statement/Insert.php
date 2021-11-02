<?php

/**
 * @license MIT
 * @license http://opensource.org/licenses/MIT
 */

namespace FaaPz\PDO\Statement;

use FaaPz\PDO\AbstractStatement;
use FaaPz\PDO\Clause\RawInterface;
use FaaPz\PDO\Database;
use FaaPz\PDO\QueryInterface;

class Insert extends AbstractStatement implements InsertInterface
{
    /** @var ?string */
    protected $priority = null;

    /** @var bool $ignore */
    protected $ignore = false;

    /** @var ?string $table */
    protected $table = null;

    /** @var array<string> $columns */
    protected $columns = [];

    /** @var array<array<float|int|string|RawInterface|SelectInterface>> $values */
    protected $values = [];

    /** @var array<string, mixed> $update */
    protected $update = [];


    /**
     * @param Database      $dbh
     * @param array<string> $columns
     */
    public function __construct(Database $dbh, array $columns = [])
    {
        parent::__construct($dbh);

        $this->columns(...$columns);
    }

    /**
     * @param string $level
     *
     * @return self
     */
    public function priority(string $level): self
    {
        $this->priority = strtoupper(trim($level));

        return $this;
    }

    /**
     * @return string
     */
    protected function renderPriority(): string
    {
        $sql = '';
        if ($this->priority != null) {
            switch ($this->priority) {
                case 'LOW':
                case 'HIGH':
                    $sql = " {$this->priority}_PRIORITY";
                    break;

                case 'LOW_PRIORITY':
                case 'DELAYED':
                case 'HIGH_PRIORITY':
                    $sql = " {$this->priority}";
                    break;

                default:
                    trigger_error('Invalid priority type for insert statement', E_USER_ERROR);
            }
        }

        return $sql;
    }

    /**
     * @return self
     */
    public function ignore(): self
    {
        $this->ignore = true;

        return $this;
    }

    /**
     * @return string
     */
    protected function renderIgnore(): string
    {
        $sql = '';
        if ($this->ignore) {
            $sql = ' IGNORE';
        }

        return $sql;
    }


    /**
     * @param string $table
     *
     * @return self
     */
    public function into(string $table): self
    {
        $this->table = $table;

        return $this;
    }

    /**
     * @return string
     */
    protected function renderInto(): string
    {
        if (empty($this->table)) {
            trigger_error('No table set for insert statement', E_USER_ERROR);
        }

        return " INTO {$this->table}";
    }

    /**
     * @param string ...$columns
     *
     * @return self
     */
    public function columns(string ...$columns): self
    {
        $this->columns = $columns;

        return $this;
    }

    /**
     * @return string
     */
    protected function renderColumns(): string
    {
        $sql = '';
        if (!empty($this->columns)) {
            $sql = ' (' . implode(', ', $this->columns) . ')';
        }

        return $sql;
    }

    /**
     * @param float|int|string|RawInterface|SelectInterface $value
     * @param float|int|string|RawInterface                 ...$values
     *
     * @return self
     */
    public function values($value, ...$values): self
    {
        array_unshift($values, $value);
        $this->values[] = $values;

        return $this;
    }

    /**
     * @phan-suppress PhanTypeMismatchProperty https://github.com/phan/phan/issues/4609
     *
     * @return string
     */
    protected function renderValues(): string
    {
        $length = count($this->values);
        if ($length < 1) {
            trigger_error('No values set for insert statement', E_USER_ERROR);
        }

        $sql = '';
        if ($this->values[0][0] instanceof SelectInterface) {
            if ($length > 1 || count($this->values[0]) > 1) {
                trigger_error('Ignoring additional values after select for insert statement', E_USER_WARNING);
                $this->values = array_slice($this->values, 0, 1);
            }

            $sql .= " {$this->values[0][0]}";
        } else {
            $width = count($this->values[0]);
            if (count($this->columns) > 0 && $width != count($this->columns)) {
                trigger_error('Column value count mismatch for insert statement', E_USER_ERROR);
            }

            $sql .= ' VALUES ';
            for ($y = 0; $y < $length; $y++) {
                if ($y > 0) {
                    if ($width != count($this->values[$y])) {
                        trigger_error('Invalid nested value count for insert statement', E_USER_ERROR);
                    }

                    $sql .= ', ';
                }

                $row = '';
                for ($x = 0; $x < $width; $x++) {
                    if ($x > 0) {
                        $row .= ', ';
                    }

                    if (
                        $this->values[$y][$x] === null
                        || (is_scalar($this->values[$y][$x]) && !is_bool($this->values[$y][$x]))
                    ) {
                        $row .= '?';
                    } elseif ($this->values[$y][$x] instanceof RawInterface) {
                        $row .= $this->values[$y][$x];
                    } else {
                        trigger_error('Invalid value for insert statement', E_USER_ERROR);
                    }
                }

                if (!empty($row)) {
                    $sql .= "({$row})";
                }
            }
        }

        return $sql;
    }

    /**
     * @param array<string, float|int|string|RawInterface> $paris
     *
     * @return self
     */
    public function onDuplicateUpdate(array $paris = []): self
    {
        $this->update = $paris;

        return $this;
    }

    /**
     * @return string
     */
    protected function renderOnDuplicateUpdate(): string
    {
        $sql = '';
        if (!empty($this->update)) {
            $sql = ' ON DUPLICATE KEY UPDATE';
            foreach ($this->update as $column => $value) {
                if (!$value instanceof RawInterface) {
                    if ($value !== null && (!is_scalar($value) || is_bool($value))) {
                        trigger_error('Invalid value for insert on duplicate value', E_USER_ERROR);
                    }

                    $value = '?';
                }

                $sql .= " {$column} = {$value}, ";
            }
            $sql = substr($sql, 0, -2);
        }

        return $sql;
    }

    /**
     * @return array<mixed>
     */
    public function getValues(): array
    {
        $values = [];
        foreach ($this->values as $row) {
            if ($row instanceof SelectInterface) {
                $values = array_merge($values, $row->getValues());
            } else {
                foreach ($row as $value) {
                    if ($value instanceof QueryInterface) {
                        $values = array_merge($values, $value->getValues());
                    } else {
                        $values[] = $value;
                    }
                }
            }
        }

        foreach ($this->update as $value) {
            if ($value instanceof QueryInterface) {
                $values = array_merge($values, $value->getValues());
            } else {
                $values[] = $value;
            }
        }

        return $values;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return 'INSERT'
            . $this->renderPriority()
            . $this->renderIgnore()
            . $this->renderInto()
            . $this->renderColumns()
            . $this->renderValues()
            . $this->renderOnDuplicateUpdate();
    }
}
