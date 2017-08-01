<?php
/**
 * This class provides functionality of handling PHP errors
 */
declare(strict_types=1);

namespace Maleficarum\Handler;

class ErrorHandler extends \Maleficarum\Handler\AbstractHandler {
    /**
     * Generic PHP error handling functionality. For now it just converts errors into runtime exceptions and lets the exception handler deal with them.
     *
     * @param int $code
     * @param string $message
     * @param string $file
     * @param int $line
     * @param array $context
     *
     * @return void
     * @throws \RuntimeException
     */
    public function handle(int $code, string $message, string $file, int $line, array $context) {
        throw new \RuntimeException('[PHP Error] Code: ' . $code . ', Comment: ' . $message . ', File: ' . $file . ', Line: ' . $line);
    }
}
