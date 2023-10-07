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
            try {
                throw new ValidationException($validations);
            } catch (ValidationException $e) {
                http_response_code($e->getStatus());

                header('Content-Type: application/json');
                echo json_encode([
                    'status' => 'error',
                    'code' => $e->getStatus(),
                    'message' => $e->getMessage(),
                    'errors' => $e->getErrors()
                ]);
                exit;
            }
        }

        return $this->request;
    }
}