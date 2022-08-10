<?php

/**
 * @license MIT
 * @license http://opensource.org/licenses/MIT
 */

namespace FaaPz\PDO\Test\Clause;

use FaaPz\PDO\Clause\Raw;
use PHPUnit\Framework\TestCase;

class RawTest extends TestCase
{
    /** @var Raw $subject */
    private $subject;

    public function setUp(): void
    {
        parent::setUp();

        $this->subject = new Raw('test');
    }

    public function testToString()
    {
        $this->assertEquals('test', $this->subject->__toString());
    }

    public function testGetValues()
    {
        $this->assertIsArray($this->subject->getValues());
        $this->assertEmpty($this->subject->getValues());
    }
}
