<?php
/**
 * This class represents unauthorized exception.
 */
declare(strict_types=1);

namespace Maleficarum\Exception;

class UnauthorizedException extends HttpException {
    /**
     * UnauthorizedException constructor.
     *
     * @param string $message
     * @param int $code
     * @param \Exception $previous
     */
    public function __construct(string $message = '', int $code = 0, \Exception $previous = null) {
        parent::__construct(401, 'Unauthorized', $message, $code, $previous);
    }
}
