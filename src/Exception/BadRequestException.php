<?php
/**
 * This exception gets thrown when API receives a bad request.
 * @extends \Exception
 */

namespace Maleficarum\Exception;

class BadRequestException extends \Exception
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
    public function getErrors() {
        return $this->errors;
    }

    /**
     * Set error list.
     *
     * @param array $errors
     *
     * @return \Maleficarum\Exception\BadRequestException
     */
    public function setErrors(array $errors) {
        $this->errors = $errors;

        return $this;
    }
    /* ------------------------------------ Setters & Getters END -------------------------------------- */
}
