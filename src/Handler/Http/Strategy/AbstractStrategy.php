<?php
/**
 * This class is a base for all handler response strategies
 */
declare(strict_types=1);

namespace Maleficarum\Handler\Http\Strategy;

abstract class AbstractStrategy {
    /**
     * Use \Maleficarum\Response\Dependant functionality.
     *
     * @trait
     */
    use \Maleficarum\Response\Dependant;

    /* ------------------------------------ Abstract methods START ------------------------------------- */
    /**
     * Render response for the current strategy
     *
     * @param \Throwable $throwable
     * @param int $debugLevel
     *
     * @return void
     */
    abstract public function render(\Throwable $throwable, int $debugLevel);

    /**
     * Render response without using response object
     *
     * @return void
     */
    abstract protected function renderGeneric();
    /* ------------------------------------ Abstract methods END --------------------------------------- */

    /* ------------------------------------ AbstractStrategy methods START ----------------------------- */
    /**
     * Get status code for given exception
     *
     * @param \Throwable $throwable
     *
     * @return int
     */
    protected function getStatusCode(\Throwable $throwable): int {
        $statusCode = 500;
        if ($throwable instanceof \Maleficarum\Exception\HttpException) {
            $statusCode = $throwable->getStatusCode();
        }

        return $statusCode;
    }

    /**
     * Get reason phrase for given exception
     *
     * @param \Throwable $throwable
     *
     * @return string
     */
    protected function getReasonPhrase(\Throwable $throwable): string {
        $reasonPhrase = 'Internal Server Error';
        if ($throwable instanceof \Maleficarum\Exception\HttpException) {
            $reasonPhrase = $throwable->getReasonPhrase();
        }

        return $reasonPhrase;
    }

    /**
     * Get message for exception
     *
     * @param \Throwable $throwable
     * @param int $debugLevel
     *
     * @return string
     */
    protected function getMessage(\Throwable $throwable, int $debugLevel): string {
        if (!$throwable instanceof \Maleficarum\Exception\HttpException) {
            return $debugLevel > \Maleficarum\Handler\AbstractHandler::DEBUG_LEVEL_CRUCIAL ? $throwable->getMessage() : 'API Error';
        }

        $defaultMessage = sprintf('%d %s', $throwable->getStatusCode(), $throwable->getReasonPhrase());

        // set response message based on debug level
        $message = $debugLevel >= \Maleficarum\Handler\AbstractHandler::DEBUG_LEVEL_LIMITED ? $throwable->getMessage() : $defaultMessage;
        $message = empty($message) ? $defaultMessage : $message;

        return $message;
    }

    /**
     * Get exception errors
     *
     * @param \Throwable $throwable
     *
     * @return array
     */
    protected function getErrors(\Throwable $throwable): array {
        if (method_exists($throwable, 'getErrors')) {
            return $throwable->getErrors();
        }

        return [];
    }

    /**
     * Get exception details
     *
     * @param \Throwable $throwable
     * @param int $debugLevel
     *
     * @return array
     */
    protected function getExceptionDetails(\Throwable $throwable, int $debugLevel): array {
        $details = [];

        if ($throwable instanceof \Maleficarum\Exception\HttpException) {
            return $details;
        }

        if ($debugLevel > \Maleficarum\Handler\AbstractHandler::DEBUG_LEVEL_CRUCIAL) {
            $details = [
                'line' => $throwable->getLine(),
                'file' => $throwable->getFile(),
                'trace' => $throwable->getTrace(),
            ];
        }

        return $details;
    }

    /**
     * Attach response headers
     *
     * @param int $statusCode
     * @param string $reasonPhrase
     * @param string $contentType
     *
     * @return void
     */
    protected function attachHeaders(int $statusCode, string $reasonPhrase, string $contentType) {
        header(sprintf('HTTP/1.1 %d %s', $statusCode, $reasonPhrase));
        header('Content-type: ' . $contentType);
    }

    /**
     * Terminate execution
     *
     * @return void
     */
    protected function terminate() {
        exit;
    }
    /* ------------------------------------ AbstractStrategy methods END ------------------------------- */
}
