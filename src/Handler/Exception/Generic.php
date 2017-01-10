<?php

namespace Maleficarum\Handler\Exception;

class Generic extends \Maleficarum\Handler\Exception\AbstractHandler
{
    /* ------------------------------------ AbstractHandler methods START ---------------------------- */
    /**
     * @see \Maleficarum\Handler\Exception\AbstractHandler::handleResponse()
     */
    protected function handleResponse($exception, $debugLevel) {
        if (\PHP_SAPI === 'cli') {
            $this->handleCommandLineException($exception, $debugLevel);
        } else {
            $this->handleHttpException($exception, $debugLevel);
        }
    }

    /**
     * @see \Maleficarum\Handler\Exception\AbstractHandler::getResponseStatusCode()
     */
    protected function getResponseStatusCode() {
        return \Maleficarum\Response\Status::STATUS_CODE_500;
    }

    /**
     * @see \Maleficarum\Handler\Exception\AbstractHandler::getDefaultMessage()
     */
    protected function getDefaultMessage() {
        return '500 Internal Server Error';
    }

    /**
     * Handle exception for HTTP request
     *
     * @param \Exception|\Throwable $exception
     * @param int $debugLevel
     */
    private function handleHttpException($exception, $debugLevel) {
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
     * @param \Exception|\Throwable $exception
     * @param int $debugLevel
     */
    private function handleCommandLineException($exception, $debugLevel) {
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
