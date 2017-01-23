<?php
/**
 * This class provides functionality of handling generic exception
 */

namespace Maleficarum\Handler\Exception;

class Generic extends \Maleficarum\Handler\Exception\AbstractHandler
{
    /* ------------------------------------ AbstractHandler methods START ---------------------------- */
    /**
     * Handle response for generic exception
     *
     * @see \Maleficarum\Handler\Exception\AbstractHandler::handleResponse()
     *
     * @param \Throwable $exception
     * @param int $debugLevel
     *
     * @return void
     */
    protected function handleResponse(\Throwable $exception, int $debugLevel) {
        if (\PHP_SAPI === 'cli') {
            $this->handleCommandLineException($exception, $debugLevel);
        } else {
            $this->handleHttpException($exception, $debugLevel);
        }
    }

    /**
     * Get response status code for generic exception
     *
     * @see \Maleficarum\Handler\Exception\AbstractHandler::getResponseStatusCode()
     * @return int
     */
    protected function getResponseStatusCode() : int {
        return 500;
    }

    /**
     * Get default status message for generic exception
     *
     * @see \Maleficarum\Handler\Exception\AbstractHandler::getDefaultMessage()
     * @return string
     */
    protected function getDefaultMessage() : string {
        return '500 Internal Server Error';
    }

    /**
     * Handle exception for HTTP request
     *
     * @param \Throwable $exception
     * @param int $debugLevel
     *
     * @return void
     */
    private function handleHttpException(\Throwable $exception, int $debugLevel) {
        if ($debugLevel > \Maleficarum\Handler\AbstractHandler::DEBUG_LEVEL_CRUCIAL) {
            $meta = [
                'msg' => $exception->getMessage(),
                'line' => $exception->getLine(),
                'file' => $exception->getFile(),
                'trace' => $exception->getTrace()
            ];
        } else {
            $meta = [
                'msg' => $this->getDefaultMessage()
            ];
        }

        $this->render([], $meta);
    }

    /**
     * Handle exception for command line
     *
     * @param \Throwable $exception
     * @param int $debugLevel
     * 
     * @return void
     */
    private function handleCommandLineException(\Throwable $exception, int $debugLevel) {
        if ($debugLevel < \Maleficarum\Handler\AbstractHandler::DEBUG_LEVEL_FULL) {
            $msg = '[PHP Exception] GENERIC_EXCEPTION_HANDLER :: ' . $exception->getMessage() . ' :: file: ' . $exception->getFile() . ' :: line: ' . $exception->getLine();
        } else {
            $msg = '[PHP Exception] GENERIC_EXCEPTION_HANDLER :: ' . $exception->getMessage() . ' :: file: ' . $exception->getFile() . ' :: line: ' . $exception->getLine() . ' :: trace: ' . $exception->getTraceAsString();
        }

        syslog(\LOG_CRIT, $msg);
        var_dump($exception->getMessage() . " :: file: " . $exception->getFile() . " :: line: " . $exception->getLine());
        exit;
    }
    /* ------------------------------------ AbstractHandler methods END ------------------------------ */
}
