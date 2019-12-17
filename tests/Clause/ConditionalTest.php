<?php

/**
 * @license MIT
 * @license http://opensource.org/licenses/MIT
 */

declare(strict_types=1);

namespace FaaPz\PDO\Test;

use FaaPz\PDO\Clause;
use PHPUnit\Framework\TestCase;

class ConditionalTest extends TestCase
{
    public function testToString()
    {
        $subject = new Clause\Conditional('col', '=', 'val');

        $this->assertEquals('col = ?', $subject->__toString());
    }

    public function testToStringWithIn()
    {
        $subject = new Clause\Conditional('col', 'IN', [1, 2, 3]);

        $this->assertEquals('col IN (?, ?, ?)', $subject->__toString());
    }

    public function testToStringWithInException()
    {
        $subject = new Clause\Conditional('col', 'IN', []);

        $this->expectError();
        $this->expectErrorMessageMatches('/Conditional operator "IN" requires at least one argument/');

        $subject->__toString();
    }

    public function testToStringWithBetween()
    {
        $subject = new Clause\Conditional('col', 'BETWEEN', [1, 2]);

        $this->assertEquals('col BETWEEN (? AND ?)', $subject->__toString());
    }

    public function testToStringWithBetweenException()
    {
        $subject = new Clause\Conditional('col', 'BETWEEN', [1, 2, 3]);

        $this->expectError();
        $this->expectErrorMessage('Conditional operator "BETWEEN" requires two arguments');

        $subject->__toString();
    }

    public function testToStringWithQuery()
    {
        $subject = new Clause\Conditional('col', '=', new Clause\Raw(1));

        $this->assertEquals('col = 1', $subject->__toString());
    }

    public function testToStringWithQueryAndArgs()
    {
        $subject = new Clause\Conditional('col', '=', new Clause\Method('test', 1, 2));

        $this->assertEquals('col = test(?, ?)', $subject->__toString());
    }

    public function testGetValues()
    {
        $subject = new Clause\Conditional('col', '=', 'val');

        $this->assertIsArray($subject->getValues());
        $this->assertCount(1, $subject->getValues());
    }

    public function testGetValuesWithQuery()
    {
        $subject = new Clause\Conditional('col', '=', new Clause\Raw(1));

        $this->assertIsArray($subject->getValues());
        $this->assertCount(0, $subject->getValues());
        $this->assertEquals('col = 1', $subject->__toString());
    }

    public function testGetValuesWithQueryAndArgs()
    {
        $subject = new Clause\Conditional('col', '=', new Clause\Method('test', 1, 2));

        $this->assertIsArray($subject->getValues());
        $this->assertCount(2, $subject->getValues());
    }
}
