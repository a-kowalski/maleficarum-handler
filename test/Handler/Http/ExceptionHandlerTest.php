<?php
declare(strict_types = 1);

/**
 * Tests for the \Maleficarum\Handler\Http\ExceptionHandler class.
 */

namespace Maleficarum\Handler\Tests\Http;

class ExceptionHandlerTest extends \PHPUnit\Framework\TestCase
{
    /* ------------------------------------ Method: handle START --------------------------------------- */
    public function testHandleForHttpException() {
        $strategy = $this
            ->getMockBuilder('Maleficarum\Handler\Http\Strategy\AbstractStrategy')
            ->getMockForAbstractClass();
        $strategy
            ->expects($this->once())
            ->method('render');

        $handler = new \Maleficarum\Handler\Http\ExceptionHandler($strategy);

        $exception = new \Maleficarum\Exception\BadRequestException();
        $handler->handle($exception);
    }

    public function testHandleForNonHttpException() {
        $strategy = $this
            ->getMockBuilder('Maleficarum\Handler\Http\Strategy\AbstractStrategy')
            ->getMockForAbstractClass();
        $strategy
            ->expects($this->once())
            ->method('render');

        $handler = $this
            ->getMockBuilder('Maleficarum\Handler\Http\ExceptionHandler')
            ->setMethods(['log'])
            ->setConstructorArgs([$strategy])
            ->getMock();
        $handler
            ->expects($this->once())
            ->method('log');

        $exception = new \RuntimeException();
        $handler->handle($exception);
    }
    /* ------------------------------------ Method: handle END ----------------------------------------- */
}
