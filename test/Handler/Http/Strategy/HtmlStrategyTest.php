<?php
declare(strict_types = 1);

/**
 * Tests for the \Maleficarum\Handler\Http\Strategy\HtmlStrategy class.
 */

namespace Maleficarum\Handler\Tests\Http\Strategy;

class HtmlStrategyTest extends \PHPUnit\Framework\TestCase
{
    /* ------------------------------------ Method: render START --------------------------------------- */
    /**
     * @dataProvider renderDataProvider
     */
    public function testRenderExceptionWithoutResponse($debugLevel, $exception, $statusCode, $reasonPhrase, $error) {
        $strategy = $this
            ->getMockBuilder('Maleficarum\Handler\Http\Strategy\HtmlStrategy')
            ->setMethods(['renderGeneric', 'attachHeaders', 'terminate'])
            ->getMock();
        $strategy
            ->expects($this->once())
            ->method('renderGeneric')
            ->with(
                $this->callback(function ($value) use ($error, $exception, $debugLevel) {
                    if (!$exception instanceof \Maleficarum\Exception\HttpException && $debugLevel > 0) {
                        return (bool) preg_match('/' . $error . '/', $value) && preg_match('/Trace:/', $value);
                    }

                    return (bool) preg_match('/' . $error . '/', $value);
                })
            );
        $strategy
            ->expects($this->once())
            ->method('attachHeaders')
            ->with($statusCode, $reasonPhrase, 'text/html');
        $strategy
            ->expects($this->once())
            ->method('terminate');

        $strategy->render($exception, $debugLevel);
    }

    public function renderDataProvider() {
        return [
            // non http exceptions
            [0, new \RuntimeException('foo'), 500, 'Internal Server Error', 'API Error'],
            [5, new \LogicException('foo bar'), 500, 'Internal Server Error', 'foo bar'],
            // http exceptions
            [0, new \Maleficarum\Exception\BadRequestException('baz'), 400, 'Bad Request', '400 Bad Request'],
            [5, new \Maleficarum\Exception\BadRequestException('qux quux'), 400, 'Bad Request', 'qux quux'],
            [5, (new \Maleficarum\Exception\BadRequestException())->setErrors(['foo' => 'bar']), 400, 'Bad Request', '400 Bad Request'],
        ];
    }

    /**
     * @dataProvider renderDataWithResponseProvider
     */
    public function testRenderExceptionWithResponse($debugLevel, $exception, $statusCode, $data) {
        $strategy = $this
            ->getMockBuilder('Maleficarum\Handler\Http\Strategy\HtmlStrategy')
            ->setMethods(['getResponse'])
            ->getMock();

        $response = $this
            ->getMockBuilder('Maleficarum\Response\AbstractResponse')
            ->getMockForAbstractClass();
        $response
            ->expects($this->once())
            ->method('setStatusCode')
            ->with($statusCode)
            ->willReturn($response);
        $response
            ->expects($this->once())
            ->method('render')
            ->with(
                $this->equalTo('exceptions/generic'),
                $this->callback(function ($value) use ($data, $exception, $debugLevel) {
                    if (!$exception instanceof \Maleficarum\Exception\HttpException && $debugLevel > 0) {
                        // get details
                        $diff = array_diff_assoc($value, $data);

                        // check if only details are present and structure is valid
                        return 1 === count($diff) && isset($diff['details']['file'], $diff['details']['line'], $diff['details']['trace']);
                    }

                    return $value === $data;
                })
            )
            ->willReturn($response);
        $response
            ->expects($this->once())
            ->method('output');

        $strategy
            ->expects($this->once())
            ->method('getResponse')
            ->willReturn($response);

        $strategy->render($exception, $debugLevel);
    }

    public function renderDataWithResponseProvider() {
        return [
            // non http exceptions
            [0, new \RuntimeException('foo'), 500, ['statusCode' => 500, 'reasonPhrase' => 'Internal Server Error', 'message' => 'API Error', 'details' => []]],
            [5, new \LogicException('bar'), 500, ['statusCode' => 500, 'reasonPhrase' => 'Internal Server Error', 'message' => 'bar']],
            // http exceptions
            [0, new \Maleficarum\Exception\BadRequestException('baz'), 400, ['statusCode' => 400, 'reasonPhrase' => 'Bad Request', 'message' => '400 Bad Request', 'details' => []]],
            [5, new \Maleficarum\Exception\BadRequestException('qux'), 400, ['statusCode' => 400, 'reasonPhrase' => 'Bad Request', 'message' => 'qux', 'details' => []]],
            [5, (new \Maleficarum\Exception\BadRequestException())->setErrors(['foo' => 'bar']), 400, ['statusCode' => 400, 'reasonPhrase' => 'Bad Request', 'message' => '400 Bad Request', 'details' => []]],
        ];
    }
    /* ------------------------------------ Method: render END ----------------------------------------- */
}
