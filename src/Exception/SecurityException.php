<?php
/**
 * This class represents security exception
 */

namespace Maleficarum\Exception;

class SecurityException extends HttpException
{
    /**
     * SecurityException constructor.
     *
     * @param string $message
     * @param int $code
     * @param \Exception|null $previous
     */
    public function __construct(string $message = '', int $code = 0, \Exception $previous = null) {
        parent::__construct(403, 'Forbidden', $message, $code, $previous);
    }
}
