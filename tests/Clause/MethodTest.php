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
    public function testToString()
    {
        $subject = new Clause\Method('test');

        $this->assertEquals('test()', $subject->__toString());
    }

    public function testToStringWithArgs()
    {
        $subject = new Clause\Method('test', 1, 2);

        $this->assertEquals('test(?, ?)', $subject->__toString());
    }

    public function testToStringWithQuery()
    {
        $subject = new Clause\Method('test', new Clause\Raw(1));

        $this->assertEquals('test(1)', $subject->__toString());
    }

    public function testToStringWithQueryAndArgs()
    {
        $subject = new Clause\Method('test', new Clause\Method('next', 1, 2));

        $this->assertEquals('test(next(?, ?))', $subject->__toString());
    }

    public function testGetValues()
    {
        $subject = new Clause\Method('test');

        $this->assertIsArray($subject->getValues());
        $this->assertEmpty($subject->getValues());
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

    public function testGetValuesWithQueryAndArgs()
    {
        $subject = new Clause\Method('test', new Clause\Method('next', 1, 2));

        $this->assertIsArray($subject->getValues());
        $this->assertCount(2, $subject->getValues());
    }
}
