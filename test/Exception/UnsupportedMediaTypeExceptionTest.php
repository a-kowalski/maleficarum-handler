<?php
declare(strict_types = 1);

/**
 * Tests for the \Maleficarum\Exception\UnsupportedMediaTypeException class.
 */

namespace Maleficarum\Exception\Tests;

class UnsupportedMediaTypeExceptionTest extends \PHPUnit\Framework\TestCase
{
    /* ------------------------------------ Method: __construct START ---------------------------------- */
    public function testConstructWithoutErrors() {
        $exception = new \Maleficarum\Exception\UnsupportedMediaTypeException('foo');

        $this->assertSame('foo', $exception->getMessage());
        $this->assertSame(415, $exception->getStatusCode());
        $this->assertSame('Unsupported Media Type', $exception->getReasonPhrase());
    }
    /* ------------------------------------ Method: __construct END ------------------------------------ */
}
