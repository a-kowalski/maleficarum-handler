<?php
/**
 * This class provides functionality of handling conflict exception
 */

namespace Maleficarum\Handler\Exception;

class Conflict extends \Maleficarum\Handler\Exception\AbstractHandler
{
    /* ------------------------------------ AbstractHandler methods START ---------------------------- */
    /**
     * Handle response for conflict exception
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

        $this->render(['errors' => $exception->getErrors()], ['msg' => $message]);
    }

    /**
     * Get response status code for conflict
     *
     * @see \Maleficarum\Handler\Exception\AbstractHandler::getResponseStatusCode()
     * @return int
     */
    protected function getResponseStatusCode() : int {
        return 409;
    }

    /**
     * Get default status message for conflict
     *
     * @see \Maleficarum\Handler\Exception\AbstractHandler::getDefaultMessage()
     * @return string
     */
    protected function getDefaultMessage() : string {
        return '409 Conflict';
    }
    /* ------------------------------------ AbstractHandler methods END ------------------------------ */
}
