<?php
declare(strict_types = 1);

/**
 * Tests for the \Maleficarum\Handler\Http\Strategy\JsonStrategy class.
 */

namespace Maleficarum\Handler\Tests\Http\Strategy;

class JsonStrategyTest extends \PHPUnit\Framework\TestCase
{
    /* ------------------------------------ Method: render START --------------------------------------- */
    /**
     * @dataProvider renderDataWithoutResponseProvider
     */
    public function testRenderExceptionWithoutResponse($debugLevel, $exception, $statusCode, $reasonPhrase, $meta, $data) {
        $strategy = $this
            ->getMockBuilder('Maleficarum\Handler\Http\Strategy\JsonStrategy')
            ->setMethods(['renderGeneric', 'attachHeaders', 'terminate'])
            ->getMock();
        $strategy
            ->expects($this->once())
            ->method('renderGeneric')
            ->with(
                $this->callback(function ($value) use ($meta, $exception, $debugLevel) {
                    if (!$exception instanceof \Maleficarum\Exception\HttpException && $debugLevel > 0) {
                        return isset($value['status'], $value['msg'], $value['file'], $value['line'], $value['trace']) && $meta['msg'] === $value['msg'];
                    }

                    return $value === $meta;
                }),
                $this->equalTo($data)
            );
        $strategy
            ->expects($this->once())
            ->method('attachHeaders')
            ->with($statusCode, $reasonPhrase, 'application/json');
        $strategy
            ->expects($this->once())
            ->method('terminate');

        $strategy->render($exception, $debugLevel);
    }

    public function renderDataWithoutResponseProvider() {
        return [
            // non http exceptions
            [0, new \RuntimeException('foo'), 500, 'Internal Server Error', ['status' => 'failure', 'msg' => 'API Error'], []],
            [5, new \LogicException('bar'), 500, 'Internal Server Error', ['status' => 'failure', 'msg' => 'bar'], []],
            // http exceptions
            [0, new \Maleficarum\Exception\BadRequestException('baz'), 400, 'Bad Request', ['status' => 'failure', 'msg' => '400 Bad Request'], []],
            [5, new \Maleficarum\Exception\BadRequestException('qux'), 400, 'Bad Request', ['status' => 'failure', 'msg' => 'qux'], []],
            [5, (new \Maleficarum\Exception\BadRequestException())->setErrors(['foo' => 'bar']), 400, 'Bad Request', ['status' => 'failure', 'msg' => '400 Bad Request'], ['errors' => ['foo' => 'bar']]],
        ];
    }

    /**
     * @dataProvider renderDataWithResponseProvider
     */
    public function testRenderExceptionWithResponse($debugLevel, $exception, $statusCode, $meta, $data) {
        $strategy = $this
            ->getMockBuilder('Maleficarum\Handler\Http\Strategy\JsonStrategy')
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
                $this->equalTo($data),
                $this->callback(function ($value) use ($meta, $exception, $debugLevel) {
                    if (!$exception instanceof \Maleficarum\Exception\HttpException && $debugLevel > 0) {
                        // get details
                        $diff = array_diff_assoc($value, $meta);

                        // check if only file, line and trace are present
                        return 3 === count($diff) && isset($diff['file'], $diff['line'], $diff['trace']);
                    }

                    return $value === $meta;
                }),
                $this->isFalse()
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
            [0, new \RuntimeException('foo'), 500, ['status' => 'failure', 'msg' => 'API Error'], []],
            [5, new \LogicException('bar'), 500, ['status' => 'failure', 'msg' => 'bar'], []],
            // http exceptions
            [0, new \Maleficarum\Exception\BadRequestException('baz'), 400, ['status' => 'failure', 'msg' => '400 Bad Request'], []],
            [5, new \Maleficarum\Exception\BadRequestException('qux'), 400, ['status' => 'failure', 'msg' => 'qux'], []],
            [5, (new \Maleficarum\Exception\BadRequestException())->setErrors(['foo' => 'bar']), 400, ['status' => 'failure', 'msg' => '400 Bad Request'], ['errors' => ['foo' => 'bar']]],
        ];
    }
    /* ------------------------------------ Method: render END ----------------------------------------- */
}
