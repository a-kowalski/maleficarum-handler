<?php
declare(strict_types = 1);

/**
 * Tests for the \Maleficarum\Exception\HttpException class.
 */

namespace Maleficarum\Exception\Tests;

class HttpExceptionTest extends \PHPUnit\Framework\TestCase
{
    /* ------------------------------------ Method: __construct START ---------------------------------- */
    public function testConstructWithoutErrors() {
        $exception = new \Maleficarum\Exception\HttpException(400, 'foo', 'bar');

        $this->assertSame('foo', $exception->getReasonPhrase());
        $this->assertSame('bar', $exception->getMessage());
        $this->assertSame(400, $exception->getStatusCode());
    }
    /* ------------------------------------ Method: __construct END ------------------------------------ */
}
