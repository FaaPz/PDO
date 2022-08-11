<?php

/**
 * @license MIT
 * @license http://opensource.org/licenses/MIT
 */

namespace FaaPz\PDO\Statement;

use FaaPz\PDO\Clause\MethodInterface;
use FaaPz\PDO\Definition\IndexInterface;
use FaaPz\PDO\Definition\SchemaInterface;
use FaaPz\PDO\Definition\TableInterface;
use FaaPz\PDO\Definition\UserInterface;
use FaaPz\PDO\Definition\ViewInterface;
use FaaPz\PDO\StatementInterface;

interface CreateInterface extends StatementInterface
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
