<?php

namespace Abdrashov\Sanitization;

use Abdrashov\Sanitization\Exception\ValidationException;
use Abdrashov\Sanitization\Validation\SanitizationValidation;

class Sanitization
{
    protected array $request;

    protected SanitizationValidation $validation;

    protected array $rules = [
        'baz' => \Abdrashov\Sanitization\Rule\PhoneRule::class,
        'foo' => \Abdrashov\Sanitization\Rule\NumericRule::class,
        'bar' => \Abdrashov\Sanitization\Rule\StringRule::class,
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
        foreach ($this->rules as $attribute => $ruleClass) {
            $this->validation->setRule(new $ruleClass);

            if ($value = data_get($this->request, $attribute)) {
                $this->validation->setValue($value);
            } else {
                $this->validation->setException('required', $attribute);
                continue;
            }

            if ($this->validation->rule()->validate())
                $this->request[$attribute] = $this->validation->rule()->rebirth();
            else
                $this->validation->setException($this->validation->rule()->type(), $attribute);
        }

        $this->throwException();
    }

    protected function throwException(): void
    {
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

            exit();
        }
    }
}