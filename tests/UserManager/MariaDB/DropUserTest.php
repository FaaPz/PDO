<?php

namespace FaaPz\PDO\Test\UserManager\MariaDB;

use FaaPz\PDO\Definition\DropUser;
use PDO;
use PHPUnit\Framework\TestCase;

class DropUserTest extends TestCase
{

    private string $user;
    private string $host;
    private $subject;

    public function setUp(): void
    {
        $this->user = 'bob';
        $this->host = 'localhost';

        $this->subject = new DropUser(
            
            $this->createMock(PDO::class),
            $this->host,
            $this->user
        );
    }

    public function testDropUser()
    {
        $sql = $this->subject->__toString();

        $expect = "DROP USER {$this->user}@{$this->host}";

        $this->assertEquals($expect, $sql);
    }

    public function testDropUserIfExists()
    {
        $sql = $this->subject->ifExists()->__toString();

        $expect = "DROP USER IF EXISTS {$this->user}@{$this->host}";

        $this->assertEquals($expect, $sql);
    }
}