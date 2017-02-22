<?php
/**
 * This class represents service unavailable exception
 */

namespace Maleficarum\Exception;

class ServiceUnavailableException extends HttpException
{
    /**
     * ServiceUnavailableException constructor.
     *
     * @param string $message
     * @param int $code
     * @param \Exception|null $previous
     */
    public function __construct(string $message = '', int $code = 0, \Exception $previous = null) {
        parent::__construct(503, 'Service Unavailable', $message, $code, $previous);
    }
}
