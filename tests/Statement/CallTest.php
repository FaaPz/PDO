<?php

/**
 * @license MIT
 * @license http://opensource.org/licenses/MIT
 */

namespace FaaPz\PDO\Test;

use FaaPz\PDO\Clause;
use FaaPz\PDO\DatabaseException;
use FaaPz\PDO\Statement;
use PDO;
use PHPUnit\Framework\TestCase;

class CallTest extends TestCase
{
    /** @var Statement\Call $subject */
    private $subject;

    public function setUp(): void
    {
        parent::setUp();

        $this->subject = new Statement\Call($this->createMock(PDO::class));
    }

    public function testToString()
    {
        $this->subject->method(new Clause\Method('MyFunc'));

        $this->assertStringStartsWith('CALL', $this->subject->__toString());
    }

    public function testToStringWithoutMethod()
    {
        $this->expectException(DatabaseException::class);

        $this->subject->__toString();
    }

    public function testGetValues()
    {
        $this->subject->method(new Clause\Method('MyFunc', 1, 2));

        $this->assertIsArray($this->subject->getValues());
        $this->assertCount(2, $this->subject->getValues());
    }
}
