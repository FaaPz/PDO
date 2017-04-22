<?php

/**
 * @license MIT
 * @license http://opensource.org/licenses/MIT
 */
namespace Slim\PDO\Clause;

use Slim\PDO\StatementInterface;

/**
 * Class Expression.
 *
 * @author Fabian de Laender <fabian@faapz.nl>
 */
class Method implements StatementInterface
{
    /** @var string $expression */
    protected $name;

    /** @var array $values */
    protected $values;

    /**
     * Conditional constructor.
     * @param string $name
     * @param array $values
     */
    public function __construct($name, array $values = [])
    {
        $this->name = strtoupper($name);
        $this->values = $values;
    }

    public function getValues()
    {
        return $this->values;
    }

    /**
     * @return string
     */
    public function __toString()
    {
        $placeholders = rtrim(str_repeat("?, ", count($this->values)), ", ");
        return "{$this->name}({$placeholders})";
    }
}
