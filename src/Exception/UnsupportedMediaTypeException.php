<?php
/**
 * This class represents unsupported media type exception
 */

namespace Maleficarum\Exception;

class UnsupportedMediaTypeException extends HttpException
{
    /**
     * UnsupportedMediaTypeException constructor.
     *
     * @param string $message
     * @param int $code
     * @param \Exception|null $previous
     */
    public function __construct(string $message = '', int $code = 0, \Exception $previous = null) {
        parent::__construct(415, 'Unsupported Media Type', $message, $code, $previous);
    }
}
