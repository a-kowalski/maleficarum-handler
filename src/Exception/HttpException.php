<?php
/**
 * This class is a base for all HTTP exceptions
 */
declare(strict_types=1);

namespace Maleficarum\Exception;

class HttpException extends \RuntimeException {
    /**
     * Internal storage for response status code
     *
     * @var int
     */
    private $statusCode;

    /**
     * Internal storage for response reason phrase
     *
     * @var string
     */
    private $reasonPhrase;

    /* ------------------------------------ Magic methods START ---------------------------------------- */
    /**
     * HttpException constructor.
     *
     * @param int $statusCode
     * @param string $reasonPhrase
     * @param string $message
     * @param int $code
     * @param \Exception|null $previous
     */
    public function __construct(int $statusCode, string $reasonPhrase, string $message = '', int $code = 0, \Exception $previous = null) {
        $this->statusCode = $statusCode;
        $this->reasonPhrase = $reasonPhrase;

        parent::__construct($message, $code, $previous);
    }
    /* ------------------------------------ Magic methods END ------------------------------------------ */

    /* ------------------------------------ Setters & Getters START ------------------------------------ */
    /**
     * Get statusCode
     *
     * @return int
     */
    public function getStatusCode(): int {
        return $this->statusCode;
    }

    /**
     * Get reasonPhrase
     *
     * @return string
     */
    public function getReasonPhrase(): string {
        return $this->reasonPhrase;
    }
    /* ------------------------------------ Setters & Getters END -------------------------------------- */
}
