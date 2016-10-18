<?php

namespace Maleficarum\Handler;

class ErrorHandler extends \Maleficarum\Handler\AbstractHandler
{
    /**
     * Handle exception
     *
     * @param int $code
     * @param string $message
     * @param string $file
     * @param int $line
     * @param array $context
     */
    public function handle($code, $message, $file, $line, array $context) {
        $handler = \Maleficarum\Ioc\Container::get('Maleficarum\Handler\Error\Generic');
        $handler->handle($code, $message, $file, $line, self::$debugLevel);
    }
}
