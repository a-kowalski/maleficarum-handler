<?php
declare(strict_types = 1);

/**
 * Tests for the \Maleficarum\Exception\ConflictException class.
 */

namespace Maleficarum\Exception\Tests;

class ConflictExceptionTest extends \PHPUnit\Framework\TestCase
{
    /* ------------------------------------ Method: __construct START ---------------------------------- */
    public function testConstructWithoutErrors() {
        $exception = new \Maleficarum\Exception\ConflictException('foo');

        $this->assertSame('foo', $exception->getMessage());
        $this->assertSame(409, $exception->getStatusCode());
        $this->assertSame('Conflict', $exception->getReasonPhrase());
        $this->assertSame([], $exception->getErrors());
    }

    public function testConstructWithErrors() {
        $exception = new \Maleficarum\Exception\ConflictException('', 0, null, ['foo' => 'bar']);

        $this->assertSame(['foo' => 'bar'], $exception->getErrors());
    }
    /* ------------------------------------ Method: __construct END ------------------------------------ */
}
