<?php

namespace Abdrashov\Sanitization\Interface;

interface SanitizationInterface
{
    public function setRequest(string $request): void;

    public function getRequest(): array;

    public function validated(): void;
}
