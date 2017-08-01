<?php
/**
 * This class represents bad request exception
 */
declare(strict_types=1);

namespace Maleficarum\Exception;

class BadRequestException extends HttpException {
    use ErrorTrait;

    /**
     * BadRequestException constructor.
     *
     * @param string $message
     * @param int $code
     * @param \Exception|null $previous
     * @param array $errors
     */
    public function __construct(string $message = '', int $code = 0, \Exception $previous = null, array $errors = []) {
        $this->setErrors($errors);

        parent::__construct(400, 'Bad Request', $message, $code, $previous);
    }
}
