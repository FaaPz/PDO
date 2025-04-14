<?php

/**
 * @license MIT
 * @license http://opensource.org/licenses/MIT
 */

namespace FaaPz\PDO\Statement;

use FaaPz\PDO\Clause\MethodInterface;
use FaaPz\PDO\StatementInterface;

interface AlterInterface extends StatementInterface
{
    /**
     * @param string $name
     *
     * @return SchemaInterface
     */
    public function schema(string $name);

    /**
     * @param string $name
     *
     * @return IndexInterface
     */
    public function index(string $name);

    /**
     * @param string $name
     *
     * @return TableInterface
     */
    public function table(string $name);

    /**
     * @param string $name
     *
     * @return UserInterface
     */
    public function user(string $name);

    /**
     * @param string $name
     *
     * @return ViewInterface
     */
    public function view(string $name);
}
