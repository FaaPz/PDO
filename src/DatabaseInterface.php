<?php

/**
 * @license MIT
 * @license http://opensource.org/licenses/MIT
 */

namespace FaaPz\PDO;

interface DatabaseInterface
{
    public function __construct(string $dsn, ?string $username = null, ?string $password = null, array $options = []);
}
