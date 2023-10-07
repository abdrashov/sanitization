<?php

namespace Abdrashov\Sanitization\Exception;

use Exception;

class ValidationException extends Exception
{
    protected int $status = 422;
    protected array $errors = [];

    public function __construct(array $errors, string $message = '', int $code = 0, Exception $previous = null)
    {
        parent::__construct(message('error'), $this->status, $previous);

        $this->errors = $errors;
    }

    public function getStatus(): int
    {
        return $this->status;
    }

    public function getErrors(): array
    {
        return $this->errors;
    }
}