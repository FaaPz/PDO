<?php

/**
 * @license MIT
 * @license http://opensource.org/licenses/MIT
 */

namespace FaaPz\PDO\Test\Statement;

use FaaPz\PDO\Clause;
use FaaPz\PDO\Database;
use FaaPz\PDO\Statement;
use PHPUnit\Framework\TestCase;

class CallTest extends TestCase
{
    /** @var Statement\Call $subject */
    private $subject;

    public function setUp(): void
    {
        parent::setUp();

        $this->subject = new Statement\Call($this->createMock(Database::class));
    }

    public function testToString()
    {
        $this->subject->method(new Clause\Method('MyFunc'));

        $this->assertStringStartsWith('CALL', $this->subject->__toString());
    }

    public function testToStringWithoutMethod()
    {
        $this->expectError();
        $this->expectErrorMessageMatches('/^No method set for call statement/');

        $this->subject->__toString();
    }

    public function testGetValues()
    {
        $this->subject->method(new Clause\Method('MyFunc', 1, 2));

        $this->assertIsArray($this->subject->getValues());
        $this->assertCount(2, $this->subject->getValues());
    }
}
