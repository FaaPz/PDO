<?php

/**
 * @license MIT
 * @license http://opensource.org/licenses/MIT
 */

declare(strict_types=1);

namespace FaaPz\PDO\Clause;

use FaaPz\PDO\QueryInterface;

class Method implements QueryInterface
{
    /** @var string $name */
    protected $name;

    /** @var mixed[] $values */
    protected $values;

    /**
     * @param string $name
     * @param mixed  ...$args
     */
    public function __construct(string $name, ...$args)
    {
        $this->name = $name;
        $this->values = $args;
    }

    /**
     * @return mixed[]
     */
    public function getValues(): array
    {
        $values = [];
        foreach ($this->values as $value) {
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
        $placeholders = '';
        foreach ($this->values as $value) {
            if (!empty($placeholders)) {
                $placeholders .= ', ';
            }

            if ($value instanceof QueryInterface) {
                $placeholders .= "{$value}";
            } else {
                $placeholders .= '?';
            }
        }

        return "{$this->name}({$placeholders})";
    }
}
