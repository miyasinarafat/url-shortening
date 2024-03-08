<?php

namespace Core;

use Exception;

final class ValidationException extends Exception
{
    public readonly array $errors;

    /**
     * @param $errors
     * @return void
     * @throws ValidationException
     */
    public static function throw($errors): void
    {
        $instance = new static('The form failed to validate.');

        $instance->errors = $errors;
        throw $instance;
    }
}
