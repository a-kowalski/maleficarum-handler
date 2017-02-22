<?php
declare(strict_types = 1);

/**
 * Tests for the \Maleficarum\Exception\NotFoundException class.
 */

namespace Maleficarum\Exception\Tests;

class NotFoundExceptionTest extends \PHPUnit\Framework\TestCase
{
    /* ------------------------------------ Method: __construct START ---------------------------------- */
    public function testConstructWithoutErrors() {
        $exception = new \Maleficarum\Exception\NotFoundException('foo');

        $this->assertSame('foo', $exception->getMessage());
        $this->assertSame(404, $exception->getStatusCode());
        $this->assertSame('Not Found', $exception->getReasonPhrase());
    }
    /* ------------------------------------ Method: __construct END ------------------------------------ */
}
