<?php

/**
 * @license MIT
 * @license http://opensource.org/licenses/MIT
 */

namespace FaaPz\PDO\Test;

use FaaPz\PDO\AbstractStatement;
use FaaPz\PDO\Database;
use PDOStatement;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

class AbstractStatementTest extends TestCase
{
    /** @var AbstractStatement $subject */
    private $subject;

    /** @var MockObject $mock */
    private $mock;

    public function setUp(): void
    {
        parent::setUp();

        $this->mock = $this->createMock(PDOStatement::class);
        $this->mock->method('errorInfo')
            ->willReturn([
                0 => 'HY100',
                1 => 100,
                2 => 'near "bogus": syntax error',
            ]);

        $pdo = $this->createMock(Database::class);
        $pdo->method('prepare')
            ->with($this->equalTo('toString'))
            ->willReturn($this->mock);

        $this->subject = new class ($pdo) extends AbstractStatement {
            public function getValues(): array
            {
                return [];
            }

            public function __toString(): string
            {
                return 'toString';
            }
        };
    }

    public function testExecute()
    {
        $this->mock
            ->method('execute')
            ->willReturn(true);

        $this->assertEquals($this->mock, $this->subject->execute());
    }
}
