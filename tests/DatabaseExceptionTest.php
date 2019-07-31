<?php

/**
 * @license MIT
 * @license http://opensource.org/licenses/MIT
 */

namespace FaaPz\PDO\Test;

use Exception;
use FaaPz\PDO\DatabaseException;
use PHPUnit\Framework\TestCase;

class DatabaseExceptionTest extends TestCase
{
    /** @var DatabaseException $subject */
    private $subject;

    public function setUp(): void
    {
        parent::setUp();

        $this->subject = new DatabaseException('test', 'error', new Exception());
    }

    public function testMessage()
    {
        $this->assertEquals('test', $this->subject->getMessage());
    }

    public function testCode()
    {
        $this->assertEquals('error', $this->subject->getCode());
    }

    public function testPrevious()
    {
        $this->assertInstanceOf(Exception::class, $this->subject->getPrevious());
    }
}
