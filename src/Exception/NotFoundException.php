<?php
/**
 * This class represents not found exception
 */

namespace Maleficarum\Exception;

class NotFoundException extends HttpException
{
    /**
     * NotFoundException constructor.
     *
     * @param string $message
     * @param int $code
     * @param \Exception|null $previous
     */
    public function __construct(string $message = '', int $code = 0, \Exception $previous = null) {
        parent::__construct(404, 'Not Found', $message, $code, $previous);
    }
}
