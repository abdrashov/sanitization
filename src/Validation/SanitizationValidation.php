<?php

namespace Abdrashov\Sanitization\Validation;

use Abdrashov\Sanitization\Exception\ValidationException;
use Abdrashov\Sanitization\Rule\SanitizationRule;
use Exception;

class SanitizationValidation
{
    private array $fields;
    private array $request;

    public function __construct(array $fields, array $request)
    {
        $this->fields = $fields;
        $this->request = $request;
    }

    public function apply(): array
    {
        $validations = [];

        foreach ($this->fields as $field => $rules) {
            foreach ($rules as $rule) {
                if (!method_exists(SanitizationRule::class, $rule)) {
                    throw new Exception('Validate method does not exist.', 500);
                }

                $sanitizationRule = new SanitizationRule;
                $sanitizationRule = $sanitizationRule->{$rule}($field, data_get($this->request, $field));

                if (!$sanitizationRule['status']) {
                    $validations[] = $sanitizationRule['message'];
                    break;
                }

                $this->request[$field] = $sanitizationRule['message'];
            }
        }

        if (!empty($validations)) {
            ValidationException::message($validations, 422);
        }

        return $this->request;
    }
}