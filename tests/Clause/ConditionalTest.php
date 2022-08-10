<?php

/**
 * @license MIT
 * @license http://opensource.org/licenses/MIT
 */

namespace FaaPz\PDO\Test\Clause;

use FaaPz\PDO\Clause\Conditional;
use FaaPz\PDO\Clause\Method;
use FaaPz\PDO\Clause\Raw;
use PHPUnit\Framework\TestCase;

class ConditionalTest extends TestCase
{
    public function testToString()
    {
        $subject = new Conditional('col', '=', 'val');

        $this->assertEquals('col = ?', $subject->__toString());
    }

    public function testToStringWithIn()
    {
        $subject = new Conditional('col', 'IN', [1, 2, 3]);

        $this->assertEquals('col IN (?, ?, ?)', $subject->__toString());
    }

    public function testToStringWithInException()
    {
        $subject = new Conditional('col', 'IN', []);

        $this->expectError();
        $this->expectErrorMessageMatches("/Conditional operator 'IN' requires an array with at least one argument/");

        $subject->__toString();
    }

    public function testToStringWithBetween()
    {
        $subject = new Conditional('col', 'BETWEEN', [1, 2]);

        $this->assertEquals('col BETWEEN (? AND ?)', $subject->__toString());
    }

    public function testToStringWithBetweenException()
    {
        $subject = new Conditional('col', 'BETWEEN', [1, 2, 3]);

        $this->expectError();
        $this->expectErrorMessage("Conditional operator 'BETWEEN' requires an array with exactly two arguments");

        $subject->__toString();
    }

    public function testToStringWithQuery()
    {
        $subject = new Conditional('col', '=', new Raw(1));

        $this->assertEquals('col = 1', $subject->__toString());
    }

    public function testToStringWithQueryAndArgs()
    {
        $subject = new Conditional('col', '=', new Method('test', 1, 2));

        $this->assertEquals('col = test(?, ?)', $subject->__toString());
    }

    public function testGetValues()
    {
        $subject = new Conditional('col', '=', 'val');

        $this->assertIsArray($subject->getValues());
        $this->assertCount(1, $subject->getValues());
    }

    public function testGetValuesWithQuery()
    {
        $subject = new Conditional('col', '=', new Raw(1));

        $this->assertIsArray($subject->getValues());
        $this->assertCount(0, $subject->getValues());
        $this->assertEquals('col = 1', $subject->__toString());
    }

    public function testGetValuesWithQueryAndArgs()
    {
        $subject = new Conditional('col', '=', new Method('test', 1, 2));

        $this->assertIsArray($subject->getValues());
        $this->assertCount(2, $subject->getValues());
    }
}
