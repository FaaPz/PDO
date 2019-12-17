<?php

/**
 * @license MIT
 * @license http://opensource.org/licenses/MIT
 */

declare(strict_types=1);

namespace FaaPz\PDO\Test;

use FaaPz\PDO\AbstractStatement;
use PDO;
use PDOException;
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

        $pdo = $this->createMock(PDO::class);
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

    public function testExecuteSuccess()
    {
        $this->mock
            ->method('execute')
            ->willReturn(true);

        $this->assertEquals($this->mock, $this->subject->execute());
    }

    public function testExecuteException()
    {
        $this->mock
            ->method('execute')
            ->willThrowException(new PDOException('message', 100));

        $this->expectException(PDOException::class);
        $this->expectExceptionCode(100);
        $this->expectExceptionMessage('message');

        $this->subject->execute();
    }

    public function testExecuteFailure()
    {
        $this->mock
            ->method('execute')
            ->willReturn(false);

        $this->expectError();
        $this->expectErrorMessageMatches('/^SQLSTATE\[HY100\] \[100\] .* syntax error$/');

        $this->subject->execute();
    }
}
