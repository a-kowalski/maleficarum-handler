<?php
/**
 * This class provides functionality of handling service unavailable exception
 */

namespace Maleficarum\Handler\Exception;

class ServiceUnavailable extends \Maleficarum\Handler\Exception\AbstractHandler
{
    /* ------------------------------------ AbstractHandler methods START ---------------------------- */
    /**
     * Handle response for service unavailable exception
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
     * Get response status code for service unavailable exception
     *
     * @see \Maleficarum\Handler\Exception\AbstractHandler::getResponseStatusCode()
     * @return int
     */
    protected function getResponseStatusCode() : int {
        return 503;
    }

    /**
     * Get default status message for service unavailable exception
     *
     * @see \Maleficarum\Handler\Exception\AbstractHandler::getDefaultMessage()
     * @return string
     */
    protected function getDefaultMessage() : string {
        return '503 Service Unavailable';
    }
    /* ------------------------------------ AbstractHandler methods END ------------------------------ */
}
