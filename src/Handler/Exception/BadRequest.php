<?php
/**
 * This class provides functionality of handling bad request exception
 */

namespace Maleficarum\Handler\Exception;

class BadRequest extends \Maleficarum\Handler\Exception\AbstractHandler
{
    /* ------------------------------------ AbstractHandler methods START ---------------------------- */
    /**
     * Handle response for bad request exception
     *
     * @see \Maleficarum\Handler\Exception\AbstractHandler::handleResponse()
     *
     * @param \Throwable $exception
     * @param int $debugLevel
     *
     * @return void
     */
    protected function handleResponse(\Throwable $exception, int $debugLevel) {
        $this->render(['errors' => $exception->getErrors()], ['msg' => $this->getDefaultMessage()]);
    }

    /**
     * Get response status code for bad request
     *
     * @see \Maleficarum\Handler\Exception\AbstractHandler::getResponseStatusCode()
     * @return int
     */
    protected function getResponseStatusCode() : int {
        return 400;
    }

    /**
     * Get default status message for bad request
     *
     * @see \Maleficarum\Handler\Exception\AbstractHandler::getDefaultMessage()
     * @return string
     */
    protected function getDefaultMessage() : string {
        return '400 Bad Request';
    }
    /* ------------------------------------ AbstractHandler methods END ------------------------------ */
}
