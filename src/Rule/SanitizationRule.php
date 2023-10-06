<?php

namespace Abdrashov\Sanitization\Rule;

use Abdrashov\Sanitization\Exception\ValidationException;
use Abdrashov\Sanitization\Interface\SanitizationInterface;
use Abdrashov\Sanitization\Interface\SanitizationRuleInterface;

class SanitizationRule
{
    private const SUCCESS = true;
    private const ERROR = false;

    public function trim(string $field, string|null $value): array
    {
        return [
            'status' => static::SUCCESS,
            'message' => trim($value)
        ];
    }

    public function required(string $field, string|null $value): array
    {
        if (empty($value))
            return [
                'status' => static::ERROR,
                'message' => validation_message('required', $field)
            ];

        return [
            'status' => static::SUCCESS,
            'message' => $value
        ];
    }

    public function numeric(string $field, string $value): array
    {
        if (!is_numeric($value) && !empty($value))
            return [
                'status' => static::ERROR,
                'message' => validation_message('numeric', $field)
            ];

        return [
            'status' => static::SUCCESS,
            'message' => $value == intval($value) ? intval($value) : floatval($value)
        ];
    }

    public function string(string $field, string $value): array
    {
        if (preg_match('/\d/', $value) && !empty($value))
            return [
                'status' => static::ERROR,
                'message' => validation_message('string', $field)
            ];

        return [
            'status' => static::SUCCESS,
            'message' => $value
        ];
    }

    public function phone(string $field, string $value): array
    {
        if (!preg_match('/^8 \(\d{3}\) \d{3}-\d{2}-\d{2}$/', $value) && !empty($value))
            return [
                'status' => static::ERROR,
                'message' => validation_message('phone', $field)
            ];

        return [
            'status' => static::SUCCESS,
            'message' => $value
        ];
    }
}