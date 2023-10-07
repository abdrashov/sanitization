<?php

namespace Abdrashov\Sanitization\Exception;

use Exception;
use InvalidArgumentException;

class ValidationException extends InvalidArgumentException
{
    protected array $errors;
    protected int $status = 422;

    public function __construct(array $errors, string $message = '')
    {
        parent::__construct(message('error.message'));

        $this->errors = $errors;
    }

    public function getErrors(): array
    {
        return $this->errors;
    }

    public function getStatus(): int
    {
        return $this->status;
    }
}