<?php

namespace Faapz\PDO\Test\UserManager\MariaDB;

use PDO;
use PHPUnit\Framework\TestCase;
use FaaPz\PDO\UserManager\MariaDB\RevokePrivileges;

class RevokePrivilegesTest extends TestCase
{
    private array $privileges;
    private string $user = 'bob';
    private string $host = 'localhost';
    private string $database = 'db';
    private string $table = 'tb';


    public function setUp(): void
    {

        $this->privileges = [
            'CREATE',
            'DROP',
            'DELETE',
            'INSERT',
            'SELECT',
            'UPDATE',
            'GRANT OPTION'
        ];
    }

    public function testExceptionPrivilegesIsNull()
    {

        $subject = new RevokePrivileges(
            
            $this->createMock(PDO::class),
            $this->host,
            $this->user,
            $this->database,
            $this->table
        );


        $this->expectException(\Exception::class);
        $subject->privileges([])->__toString();
    }

    public function testRevokeAllPrivileges()
    {

        $subject = new RevokePrivileges(
            
            $this->createMock(PDO::class),
            $this->host,
            $this->user
        );

        $sql = $subject->privileges()->__toString();

        $expected = "REVOKE ALL PRIVILEGES ON *.* FROM {$this->user}@{$this->host}";

        $this->assertEquals($expected, $sql);
    }

    public function testRevokePrivilegesOneOption()
    {

        $subject = new RevokePrivileges(
            
            $this->createMock(PDO::class),
            $this->host,
            $this->user
        );


        foreach ($this->privileges as $p) {
            $sql = $subject->privileges([$p])->__toString();

            $expected = "REVOKE {$p} ON *.* FROM {$this->user}@{$this->host}";

            $this->assertEquals($expected, $sql);
        }
    }

    public function testRevokePrivilegesTwoOption()
    {

        $subject = new RevokePrivileges(
            
            $this->createMock(PDO::class),
            $this->host,
            $this->user
        );

        
        $sql = $subject->privileges(['CREATE', 'DROP'])->__toString();

        $expected = "REVOKE CREATE, DROP ON *.* FROM {$this->user}@{$this->host}";

        $this->assertEquals($expected, $sql);
        
    }

    public function testRevokeAllPrivilegesWithDatabase()
    {

        $subject = new RevokePrivileges(
            
            $this->createMock(PDO::class),
            $this->host,
            $this->user,
            $this->database
        );

        $sql = $subject->privileges()->__toString();

        $expected = "REVOKE ALL PRIVILEGES ON {$this->database}.* FROM {$this->user}@{$this->host}";

        $this->assertEquals($expected, $sql);
    }

    public function testRevokeAllPrivilegesWithDatabaseAndTable()
    {

        $subject = new RevokePrivileges(
            
            $this->createMock(PDO::class),
            $this->host,
            $this->user,
            $this->database,
            $this->table
        );

        $sql = $subject->privileges()->__toString();

        $expected = "REVOKE ALL PRIVILEGES ON {$this->database}.{$this->table} FROM {$this->user}@{$this->host}";

        $this->assertEquals($expected, $sql);
    }

}

