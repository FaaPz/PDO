<?php

/**
 * @license MIT
 * @license http://opensource.org/licenses/MIT
 */

namespace FaaPz\PDO\Statement;

use FaaPz\PDO\AbstractStatement;
use FaaPz\PDO\Clause;
use PDO;
use PDOStatement;

/**
 * @method PDOStatement execute()
 */
class Call extends AbstractStatement
{
    /** @var Clause\Method $method */
    protected $method;

    /**
     * @param PDO                $dbh
     * @param Clause\Method|null $procedure
     */
    public function __construct(PDO $dbh, ?Clause\Method $procedure = null)
    {
        parent::__construct($dbh);

        if (isset($procedure)) {
            $this->method($procedure);
        }
    }

    /**
     * @param Clause\Method $procedure
     *
     * @return $this
     */
    public function method(Clause\Method $procedure): self
    {
        $this->method = $procedure;

        return $this;
    }

    /**
     * @return mixed[]
     */
    public function getValues(): array
    {
        return $this->method->getValues();
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        if (!$this->method instanceof Clause\Method) {
            trigger_error('No method set for call statement', E_USER_ERROR);
        }

        return "CALL {$this->method}";
    }
}
