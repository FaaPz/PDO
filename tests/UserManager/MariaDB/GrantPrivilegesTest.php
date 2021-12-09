<?php

namespace Faapz\PDO\Test\UserManager\MariaDB;

use PDO;
use PHPUnit\Framework\TestCase;
use FaaPz\PDO\UserManager\MariaDB\GrantPrivileges;

class GrantPrivilegesTest extends TestCase
{
    private array $privileges;
    private string $user = 'bob';
    private string $host = 'localhost';
    private string $password = '123';
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

        $subject = new GrantPrivileges(
            
            $this->createMock(PDO::class),
            $this->host,
            $this->user,
            $this->password,
            $this->database,
            $this->table
        );


        $this->expectException(\Exception::class);
        $subject->privileges([])->__toString();
    }

    public function testGrantAllPrivileges()
    {

        $subject = new GrantPrivileges(
            
            $this->createMock(PDO::class),
            $this->host,
            $this->user
        );

        $sql = $subject->privileges()->__toString();

        $expected = "GRANT ALL PRIVILEGES ON *.* TO {$this->user}@{$this->host}";

        $this->assertEquals($expected, $sql);
    }

    public function testGrantPrivilegesOneOption()
    {

        $subject = new GrantPrivileges(
            
            $this->createMock(PDO::class),
            $this->host,
            $this->user
        );


        foreach ($this->privileges as $p) {
            $sql = $subject->privileges([$p])->__toString();

            $expected = "GRANT {$p} ON *.* TO {$this->user}@{$this->host}";

            $this->assertEquals($expected, $sql);
        }
    }

    public function testGrantPrivilegesTwoOption()
    {

        $subject = new GrantPrivileges(
            
            $this->createMock(PDO::class),
            $this->host,
            $this->user
        );

        
        $sql = $subject->privileges(['CREATE', 'DROP'])->__toString();

        $expected = "GRANT CREATE, DROP ON *.* TO {$this->user}@{$this->host}";

        $this->assertEquals($expected, $sql);
        
    }

    public function testGrantAllPrivilegesWithPassword()
    {
        $subject = new GrantPrivileges(
            
            $this->createMock(PDO::class),
            $this->host,
            $this->user,
            $this->password
        );

        $sql = $subject->privileges()->__toString();

        $expected = "GRANT ALL PRIVILEGES ON *.* TO {$this->user}@{$this->host} IDENTIFIED BY '{$this->password}'";

        $this->assertEquals($expected, $sql);
    }
    
    public function testGrantPrivilegesOneOptionWithPassword()
    {

        $subject = new GrantPrivileges(
            
            $this->createMock(PDO::class),
            $this->host,
            $this->user,
            $this->password
        );

        $sql = $subject->privileges(['CREATE'])->__toString();

        $expected = "GRANT CREATE ON *.* TO {$this->user}@{$this->host} IDENTIFIED BY '{$this->password}'";

        $this->assertEquals($expected, $sql);
    }

    public function testGrantPrivilegesTwoOptionWithPassword()
    {
        $subject = new GrantPrivileges(
            
            $this->createMock(PDO::class),
            $this->host,
            $this->user,
            $this->password
        );

        $sql = $subject->privileges(['CREATE', 'DROP'])->__toString();

        $expected = "GRANT CREATE, DROP ON *.* TO {$this->user}@{$this->host} IDENTIFIED BY '{$this->password}'";

        $this->assertEquals($expected, $sql);
    }

    public function testGrantAllPrivilegesWithDatabaseAndPassword()
    {

        $subject = new GrantPrivileges(
            
            $this->createMock(PDO::class),
            $this->host,
            $this->user,
            $this->password,
            $this->database
        );

        $sql = $subject->privileges()->__toString();

        $expected = "GRANT ALL PRIVILEGES ON {$this->database}.* TO {$this->user}@{$this->host} IDENTIFIED BY '{$this->password}'";

        $this->assertEquals($expected, $sql);
    }

    public function testGrantAllPrivilegesWithDatabaseAndTableAndPassword()
    {

        $subject = new GrantPrivileges(
            
            $this->createMock(PDO::class),
            $this->host,
            $this->user,
            $this->password,
            $this->database,
            $this->table
        );

        $sql = $subject->privileges()->__toString();

        $expected = "GRANT ALL PRIVILEGES ON {$this->database}.{$this->table} TO {$this->user}@{$this->host} IDENTIFIED BY '{$this->password}'";

        $this->assertEquals($expected, $sql);
    }

}

