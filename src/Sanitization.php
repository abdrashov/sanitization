<?php

namespace Abdrashov\Sanitization;

use Abdrashov\Sanitization\Exception\ValidationException;
use Abdrashov\Sanitization\Validation\SanitizationValidation;

class Sanitization
{
    protected array $request;

    protected SanitizationValidation $validation;

    protected array $rules = [
        'phone' => \Abdrashov\Sanitization\Rule\PhoneRule::class,
        'numeric' => \Abdrashov\Sanitization\Rule\NumericRule::class,
        'string' => \Abdrashov\Sanitization\Rule\StringRule::class,
    ];

    public function __construct()
    {
        $this->validation = new SanitizationValidation;
    }

    public function setRequest(string $request): void
    {
        $this->request = json_decode($request, true);
    }

    public function getRequest(): array
    {
        return $this->request;
    }

    public function make(): void
    {
        foreach ($this->rules as $type => $ruleClass) {
            $ruleClass = extract_class($ruleClass);

            $this->validation->setRule(new $ruleClass);

            $attribute = $this->validation->rule()->attribute();

            if ($value = data_get($this->request, $attribute)) {
                $this->validation->setValue($value);
            } else {
                $this->validation->setException('required', $attribute);
                continue;
            }

            if ($this->validation->rule()->validate())
                $this->request[$attribute] = $this->validation->rule()->rebirth();
            else
                $this->validation->setException($type, $attribute);
        }

        try {
            if (!empty($this->validation->getException()))
                throw new ValidationException($this->validation->getException());
        } catch (ValidationException $e) {
            http_response_code($e->getStatus());

            header('Content-Type: application/json');

            echo json_encode([
                'code' => $e->getStatus(),
                'message' => message('error.message'),
                'errors' => $e->getErrors()
            ]);
        }
    }
}