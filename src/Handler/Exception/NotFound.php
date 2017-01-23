<?php
/**
 * This class provides functionality of handling not found exception
 */

namespace Maleficarum\Handler\Exception;

class NotFound extends \Maleficarum\Handler\Exception\AbstractHandler
{
    /* ------------------------------------ AbstractHandler methods START ---------------------------- */
    /**
     * Handle response for not found exception
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
     * Get response status code for not found exception
     *
     * @see \Maleficarum\Handler\Exception\AbstractHandler::getResponseStatusCode()
     * @return int
     */
    protected function getResponseStatusCode() : int {
        return 404;
    }

    /**
     * Get default status message for not found exception
     *
     * @see \Maleficarum\Handler\Exception\AbstractHandler::getDefaultMessage()
     * @return string
     */
    protected function getDefaultMessage() : string {
        return '404 Not Found';
    }
    /* ------------------------------------ AbstractHandler methods END ------------------------------ */
}
