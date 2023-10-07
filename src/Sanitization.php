<?php

namespace Abdrashov\Sanitization;

use Abdrashov\Sanitization\Validation\SanitizationValidation;

class Sanitization
{
    private array $request;

    public function setRequest(string $request): void
    {
        $this->request = json_decode($request, true);
    }

    public function getRequest(): array
    {
        return $this->request;
    }

    public function validated(): void
    {
        $validation = new SanitizationValidation([
            'foo' => ['trim', 'required', 'numeric'],
            'bar' => ['trim', 'required', 'string'],
            'baz' => ['trim', 'required', 'phone'],
        ], $this->request);

        $this->request = $validation->apply();
    }
}