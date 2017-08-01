<?php
/**
 * This class provides functionality of handling PHP exceptions in command line context
 */
declare(strict_types=1);

namespace Maleficarum\Handler\CommandLine;

class ExceptionHandler extends \Maleficarum\Handler\AbstractHandler {
    /**
     * Handle exception
     *
     * @param \Throwable $throwable
     *
     * @return void
     */
    public function handle(\Throwable $throwable) {
        // create a message based on current debug level
        $msg = '[PHP Exception] GENERIC_EXCEPTION_HANDLER :: ' . $throwable->getMessage() . ' :: file: ' . $throwable->getFile() . ' :: line: ' . $throwable->getLine() . ' :: trace: ' . $throwable->getTraceAsString();

        if (self::$debugLevel < \Maleficarum\Handler\AbstractHandler::DEBUG_LEVEL_FULL) {
            $msg = '[PHP Exception] GENERIC_EXCEPTION_HANDLER :: ' . $throwable->getMessage() . ' :: file: ' . $throwable->getFile() . ' :: line: ' . $throwable->getLine();
        }

        // since exception handling might be called before anything else is setup we cannot rely on nonstandard features here (so syslog() not logger)
        $this->log(\LOG_CRIT, $msg);

        var_dump($throwable->getMessage() . ' :: file: ' . $throwable->getFile() . ' :: line: ' . $throwable->getLine());

        $this->terminate();
    }
}
