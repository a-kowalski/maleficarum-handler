<?php
declare(strict_types = 1);

/**
 * Tests for the \Maleficarum\Handler\ErrorHandler class.
 */

namespace Maleficarum\Handler\Tests;

class ErrorHandlerTest extends \PHPUnit\Framework\TestCase
{
    /* ------------------------------------ Method: handle START --------------------------------------- */
    /**
     * @expectedException \RuntimeException
     */
    public function testHandle() {
        $handler = new \Maleficarum\Handler\ErrorHandler();
        $handler->handle(0, '', '', 0, []);
    }
    /* ------------------------------------ Method: handle END ----------------------------------------- */
}
