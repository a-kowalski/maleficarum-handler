<?php

namespace Maleficarum\Handler\Exception;

class Generic extends \Maleficarum\Handler\Exception\AbstractHandler
{
    /* ------------------------------------ AbstractHandler methods START ---------------------------- */
    /**
     * @see \Maleficarum\Handler\Exception\AbstractHandler::handleResponse()
     */
    protected function handleResponse($exception, $debugLevel) {
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
    /* ------------------------------------ AbstractHandler methods END ------------------------------ */
}
