<?php

/**
 * @license MIT
 * @license http://opensource.org/licenses/MIT
 */

namespace FaaPz\PDO\Test;

use FaaPz\PDO\Clause;
use PHPUnit\Framework\TestCase;

class MethodTest extends TestCase
{
    public function testToStringWithArgs()
    {
        $subject = new Clause\Method('test', 1, 2);

        $this->assertEquals('test(?, ?)', $subject->__toString());
    }

    public function testToStringWithoutArgs()
    {
        $subject = new Clause\Method('test');

        $this->assertEquals('test()', $subject->__toString());
    }

    public function testGetValuesWithArgs()
    {
        $subject = new Clause\Method('test', 1, 2);

        $this->assertIsArray($subject->getValues());
        $this->assertCount(2, $subject->getValues());
    }

    public function testGetValuesWithoutArgs()
    {
        $subject = new Clause\Method('test');

        $this->assertIsArray($subject->getValues());
        $this->assertEmpty($subject->getValues());
    }
}
