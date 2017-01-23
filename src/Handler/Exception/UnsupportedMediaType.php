<?php
/**
 * This class provides functionality of handling unsupported media type exception
 */

namespace Maleficarum\Handler\Exception;

class UnsupportedMediaType extends \Maleficarum\Handler\Exception\AbstractHandler
{
    /* ------------------------------------ AbstractHandler methods START ---------------------------- */
    /**
     * Handle response for unsupported media type exception
     *
     * @see \Maleficarum\Handler\Exception\AbstractHandler::handleResponse()
     *
     * @param \Throwable $exception
     * @param int $debugLevel
     *
     * @return void
     */
    protected function handleResponse(\Throwable $exception, int $debugLevel) {
        $message = $debugLevel >= \Maleficarum\Handler\AbstractHandler::DEBUG_LEVEL_LIMITED ? $exception->getMessage() : $this->getDefaultMessage();

        $this->render([], ['msg' => $message]);
    }

    /**
     * Get response status code for unsupported media type exception
     *
     * @see \Maleficarum\Handler\Exception\AbstractHandler::getResponseStatusCode()
     * @return int
     */
    protected function getResponseStatusCode() : int {
        return 415;
    }

    /**
     * Get default status message for unsupported media type exception
     *
     * @see \Maleficarum\Handler\Exception\AbstractHandler::getDefaultMessage()
     * @return string
     */
    protected function getDefaultMessage() : string {
        return '415 Unsupported Media Type';
    }
    /* ------------------------------------ AbstractHandler methods END ------------------------------ */
}
