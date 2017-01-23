<?php
/**
 * This class provides functionality of handling PHP errors
 */

namespace Maleficarum\Handler;

class ErrorHandler extends \Maleficarum\Handler\AbstractHandler
{
    /**
     * Handle error
     *
     * @param int $code
     * @param string $message
     * @param string $file
     * @param int $line
     * @param array $context
     *
     * @return void
     */
    public function handle(int $code, string $message, string $file, int $line, array $context) {
        /** @var \Maleficarum\Handler\Error\Generic $handler */
        $handler = \Maleficarum\Ioc\Container::get('Maleficarum\Handler\Error\Generic');
        $handler->handle($code, $message, $file, $line, $context, self::$debugLevel);
    }
}
