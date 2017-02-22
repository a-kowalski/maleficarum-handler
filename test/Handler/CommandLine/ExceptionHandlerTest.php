<?php
declare(strict_types = 1);

/**
 * Tests for the \Maleficarum\Handler\CommandLine\ExceptionHandler class.
 */

namespace Maleficarum\Handler\Tests\CommandLine;

class ExceptionHandlerTest extends \PHPUnit\Framework\TestCase
{
    /* ------------------------------------ Method: handle START --------------------------------------- */
    /**
     * @dataProvider handleDataProvider
     */
    public function testHandleForCommandLineException($debugLevel, $message) {
        \Maleficarum\Handler\CommandLine\ExceptionHandler::setDebugLevel(10);

        $handler = $this
            ->getMockBuilder('Maleficarum\Handler\CommandLine\ExceptionHandler')
            ->setMethods(['terminate', 'log'])
            ->getMock();
        $handler
            ->expects($this->once())
            ->method('log')
            ->with(
                $this->equalTo(2),
                $this->logicalAnd(
                    $this->stringContains('file'),
                    $this->stringContains('line'),
                    $this->stringContains($message)
                )
            );
        $handler
            ->expects($this->once())
            ->method('terminate');

        $exception = new \RuntimeException();
        $handler->handle($exception);

        $this->expectOutputRegex('/(?=.*file)(?=.*line)/');
    }

    public function handleDataProvider() {
        return [
            [0, 'GENERIC_EXCEPTION_HANDLER'],
            [10, 'trace'],
        ];
    }
    /* ------------------------------------ Method: handle END ----------------------------------------- */
}
