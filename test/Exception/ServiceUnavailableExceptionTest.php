<?php
declare(strict_types = 1);

/**
 * Tests for the \Maleficarum\Exception\ServiceUnavailableException class.
 */

namespace Maleficarum\Exception\Tests;

class ServiceUnavailableExceptionTest extends \PHPUnit\Framework\TestCase
{
    /* ------------------------------------ Method: __construct START ---------------------------------- */
    public function testConstructWithoutErrors() {
        $exception = new \Maleficarum\Exception\ServiceUnavailableException('foo');

        $this->assertSame('foo', $exception->getMessage());
        $this->assertSame(503, $exception->getStatusCode());
        $this->assertSame('Service Unavailable', $exception->getReasonPhrase());
    }
    /* ------------------------------------ Method: __construct END ------------------------------------ */
}
