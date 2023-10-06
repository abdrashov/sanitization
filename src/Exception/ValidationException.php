<?php

namespace Abdrashov\Sanitization\Exception;

class ValidationException
{
    public static function message($errors = [], int $code = 422)
    {
        http_response_code($code);
        header('Content-Type: application/json');

        echo json_encode(['errors' => $errors]);
        exit();
    }
}