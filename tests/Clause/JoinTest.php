<?php

/**
 * @license MIT
 * @license http://opensource.org/licenses/MIT
 */

namespace FaaPz\PDO\Test\Clause;

use FaaPz\PDO\Clause\Conditional;
use FaaPz\PDO\Clause\Grouping;
use FaaPz\PDO\Clause\Join;
use FaaPz\PDO\Database;
use FaaPz\PDO\Statement\Select;
use PHPUnit\Framework\TestCase;

class JoinTest extends TestCase
{
    public function testToString()
    {
        $subject = new Join(
            'table',
            new Conditional('column', '=', 'value')
        );

        $this->assertEquals('JOIN table ON column = ?', $subject->__toString());
    }

    public function testToStringWithType()
    {
        $subject = new Join(
            'table',
            new Conditional('column', '=', 'value'),
            'INNER'
        );

        $this->assertEquals('INNER JOIN table ON column = ?', $subject->__toString());
    }

    public function testToStringWithTableAlias()
    {
        $subject = new Join(
            ['alias' => 'table'],
            new Conditional('column1', '=', 'value1')
        );

        $this->assertEquals('JOIN table AS alias ON column1 = ?', $subject->__toString());
    }

    public function testToStringWithTableAliasException()
    {
        $subject = new Join(
            false,
            new Conditional('column1', '=', 'value1')
        );

        $this->expectError();
        $this->expectErrorMessageMatches('/^Invalid subject value/');

        $subject->__toString();
    }

    public function testToStringWithSelectTableAlias()
    {
        $subject = new Join(
            ['alias' => (new Select($this->createMock(Database::class)))->from('table')],
            new Conditional('column1', '=', 'value1')
        );

        $this->assertStringMatchesFormat('JOIN (SELECT * FROM table) AS alias ON column1 = ?', $subject->__toString());
    }

    public function testToStringWithInvalidTableAlias()
    {
        $subject = new Join(
            ['alias', 'table'],
            new Conditional('column1', '=', 'value1')
        );

        $this->expectError();
        $this->expectErrorMessageMatches('/^Invalid subject array/');

        $subject->__toString();
    }

    public function testToStringWithGrouping()
    {
        $subject = new Join(
            'table',
            new Grouping(
                'AND',
                new Conditional('column1', '=', 'value1'),
                new Conditional('column2', '=', 'value2')
            )
        );

        $this->assertEquals('JOIN table ON column1 = ? AND column2 = ?', $subject->__toString());
    }

    public function testGetValues()
    {
        $subject = new Join(
            'table',
            new Conditional('column', '=', 'value')
        );

        $this->assertIsArray($subject->getValues());
        $this->assertCount(1, $subject->getValues());
    }
}
