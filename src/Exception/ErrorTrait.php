<?php
/**
 * This trait provides functionality of storing errors
 */

namespace Maleficarum\Exception;

trait ErrorTrait
{
    /**
     * Internal storage for errors
     *
     * @var array
     */
    private $errors = [];

    /* ------------------------------------ Setters & Getters START ------------------------------------ */
    /**
     * Get errors
     *
     * @return array
     */
    public function getErrors() : array {
        return $this->errors;
    }

    /**
     * Set errors
     *
     * @param array $errors
     *
     * @return ErrorTrait
     */
    public function setErrors(array $errors) {
        $this->errors = $errors;

        return $this;
    }
    /* ------------------------------------ Setters & Getters END -------------------------------------- */
}
