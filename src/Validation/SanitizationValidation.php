<?php

namespace Abdrashov\Sanitization\Validation;

use Abdrashov\Sanitization\Exception\ValidationException;
use Abdrashov\Sanitization\Rule\Interface\RuleInterface;

class SanitizationValidation
{
    protected string $value;
    protected array $exception = [];
    protected RuleInterface $rule;

    public function setRule(RuleInterface $rule): void
    {
        $this->rule = $rule;
    }

    public function setValue(string $value): void
    {
        $this->value = $value;
        $this->rule->setValue($value);
    }

    public function rule(): RuleInterface
    {
        return $this->rule;
    }

    public function setException($message): void
    {
        $this->exception[] = $message;
    }

    public function getException(): array
    {
        return $this->exception;
    }
}