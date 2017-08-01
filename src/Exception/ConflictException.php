<?php
/**
 * This class represents conflict exception
 */
declare(strict_types=1);

namespace Maleficarum\Exception;

class ConflictException extends HttpException {
    use ErrorTrait;

    /**
     * ConflictException constructor.
     *
     * @param string $message
     * @param int $code
     * @param \Exception|null $previous
     * @param array $errors
     */
    public function __construct(string $message = '', int $code = 0, \Exception $previous = null, array $errors = []) {
        $this->setErrors($errors);

        parent::__construct(409, 'Conflict', $message, $code, $previous);
    }
}
