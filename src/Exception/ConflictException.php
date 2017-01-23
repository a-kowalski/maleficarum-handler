<?php
/**
 * This exception gets thrown when app receives a conflicting request.
 * @extends \Exception
 */

namespace Maleficarum\Exception;

class ConflictException extends \Exception
{
    /**
     * Internal storage for errors that caused this exception to be thrown.
     *
     * @var array
     */
    private $errors = [];

    /* ------------------------------------ Setters & Getters START ------------------------------------ */
    /**
     * Fetch errors.
     *
     * @return array
     */
    public function getErrors() : array {
        return $this->errors;
    }

    /**
     * Set error list.
     *
     * @param array $errors
     *
     * @return \Maleficarum\Exception\ConflictException
     */
    public function setErrors(array $errors) : ConflictException {
        $this->errors = $errors;

        return $this;
    }
    /* ------------------------------------ Setters & Getters END -------------------------------------- */
}
