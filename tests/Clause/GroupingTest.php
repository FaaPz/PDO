<?php

/**
 * @license MIT
 * @license http://opensource.org/licenses/MIT
 */

declare(strict_types=1);

namespace FaaPz\PDO\Test;

use FaaPz\PDO\Clause;
use PHPUnit\Framework\TestCase;

class GroupingTest extends TestCase
{
    public function testToString()
    {
        $subject = new Clause\Grouping(
            'AND',
            new Clause\Conditional('column1', '=', 'value1'),
            new Clause\Conditional('column2', '=', 'value2')
        );

        $this->assertEquals('column1 = ? AND column2 = ?', $subject->__toString());
    }

    public function testToStringNestedSelf()
    {
        $subject = new Clause\Grouping(
            'AND',
            new Clause\Conditional('column1', '=', 'value1'),
            new Clause\Grouping(
                'OR',
                new Clause\Conditional('column2', '=', 'value2'),
                new Clause\Conditional('column3', '=', 'value3')
            )
        );

        $this->assertEquals('column1 = ? AND (column2 = ? OR column3 = ?)', $subject->__toString());
    }

    public function testGetValues()
    {
        $subject = new Clause\Grouping(
            'AND',
            new Clause\Conditional('column1', '=', 'value1'),
            new Clause\Conditional('column2', '=', 'value2')
        );

        $this->assertIsArray($subject->getValues());
        $this->assertCount(2, $subject->getValues());
    }
}
