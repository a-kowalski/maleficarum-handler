<?php
declare(strict_types = 1);

/**
 * Tests for the \Maleficarum\Exception\SecurityException class.
 */

namespace Maleficarum\Exception\Tests;

class SecurityExceptionTest extends \PHPUnit\Framework\TestCase
{
    /* ------------------------------------ Method: __construct START ---------------------------------- */
    public function testConstructWithoutErrors() {
        $exception = new \Maleficarum\Exception\SecurityException('foo');

        $this->assertSame('foo', $exception->getMessage());
        $this->assertSame(403, $exception->getStatusCode());
        $this->assertSame('Forbidden', $exception->getReasonPhrase());
    }
    /* ------------------------------------ Method: __construct END ------------------------------------ */
}
