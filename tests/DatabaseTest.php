<?php

/**
 * @license MIT
 * @license http://opensource.org/licenses/MIT
 */

namespace FaaPz\PDO\Test;

use FaaPz\PDO\Clause\Method;
use FaaPz\PDO\Database;
use FaaPz\PDO\Statement\Call;
use FaaPz\PDO\Statement\Delete;
use FaaPz\PDO\Statement\Insert;
use FaaPz\PDO\Statement\Select;
use FaaPz\PDO\Statement\Update;
use PHPUnit\Framework\TestCase;
use ReflectionClass;
use ReflectionException;

class DatabaseTest extends TestCase
{
    /** @var Database $subject */
    private $subject;

    /**
     * @throws ReflectionException
     *
     * @return void
     */
    public function setUp(): void
    {
        parent::setUp();

        $ref = new ReflectionClass(Database::class);
        $this->subject = $ref->newInstanceWithoutConstructor();
    }

    public function testCall()
    {
        $this->assertInstanceOf(
            Call::class,
            $this->subject->call()
        );
    }

    public function testCallWithArgs()
    {
        $this->assertInstanceOf(
            Call::class,
            $this->subject->call(new Method('COUNT'))
        );
    }

    public function testSelect()
    {
        $this->assertInstanceOf(
            Select::class,
            $this->subject->select()
        );
    }

    public function testInsert()
    {
        $this->assertInstanceOf(
            Insert::class,
            $this->subject->insert()
        );
    }

    public function testUpdate()
    {
        $this->assertInstanceOf(
            Update::class,
            $this->subject->update()
        );
    }

    public function testDelete()
    {
        $this->assertInstanceOf(
            Delete::class,
            $this->subject->delete()
        );
    }
}
