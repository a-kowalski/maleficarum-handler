<?php
declare(strict_types = 1);

/**
 * Tests for the \Maleficarum\Exception\BadRequestException class.
 */

namespace Maleficarum\Exception\Tests;

class BadRequestExceptionTest extends \PHPUnit\Framework\TestCase
{
    /* ------------------------------------ Method: __construct START ---------------------------------- */
    public function testConstructWithoutErrors() {
        $exception = new \Maleficarum\Exception\BadRequestException('foo');

        $this->assertSame('foo', $exception->getMessage());
        $this->assertSame(400, $exception->getStatusCode());
        $this->assertSame('Bad Request', $exception->getReasonPhrase());
        $this->assertSame([], $exception->getErrors());
    }

    public function testConstructWithErrors() {
        $exception = new \Maleficarum\Exception\BadRequestException('', 0, null, ['foo' => 'bar']);

        $this->assertSame(['foo' => 'bar'], $exception->getErrors());
    }
    /* ------------------------------------ Method: __construct END ------------------------------------ */
}
