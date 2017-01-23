<?php
/**
 * This class is a generic handler for PHP errors
 */

namespace Maleficarum\Handler\Error;

class Generic
{
    /* ------------------------------------ Generic methods START -------------------------------------- */
    /**
     * Generic PHP error handling functionality. For now it just converts errors into runtime exceptions and
     * lets the exception handler deal with them.
     *
     * @param int $code
     * @param string $message
     * @param string $file
     * @param int $line
     * @param array $context
     * @param int $debugLevel
     *
     * @return void
     * @throws \RuntimeException
     */
    public function handle(int $code, string $message, string $file, int $line, array $context, int $debugLevel) {
        throw new \RuntimeException('[PHP Error] Code: ' . $code . ', Comment: ' . $message . ', File: ' . $file . ', Line: ' . $line);
    }
    /* ------------------------------------ Generic methods END ---------------------------------------- */
}
