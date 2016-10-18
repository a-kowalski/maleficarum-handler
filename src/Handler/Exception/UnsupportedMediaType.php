<?php

namespace Maleficarum\Handler\Exception;

class UnsupportedMediaType extends \Maleficarum\Handler\Exception\AbstractHandler
{
    /* ------------------------------------ AbstractHandler methods START ---------------------------- */
    /**
     * @see \Maleficarum\Handler\Exception\AbstractHandler::handleResponse()
     */
    protected function handleResponse($exception, $debugLevel) {
        $message = $debugLevel >= \Maleficarum\Handler\AbstractHandler::DEBUG_LEVEL_LIMITED ? $exception->getMessage() : $this->getDefaultMessage();

        $this->render([], ['msg' => $message]);
    }

    /**
     * @see \Maleficarum\Handler\Exception\AbstractHandler::getResponseStatusCode()
     */
    protected function getResponseStatusCode() {
        return \Maleficarum\Response\Status::STATUS_CODE_415;
    }

    /**
     * @see \Maleficarum\Handler\Exception\AbstractHandler::getDefaultMessage()
     */
    protected function getDefaultMessage() {
        return '415 Unsupported Media Type';
    }
    /* ------------------------------------ AbstractHandler methods END ------------------------------ */
}
