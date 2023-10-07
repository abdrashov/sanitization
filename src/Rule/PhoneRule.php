<?php

namespace Abdrashov\Sanitization\Rule;

use Abdrashov\Sanitization\Rule\Abstract\RuleAbstract;
use Abdrashov\Sanitization\Rule\Interface\RuleInterface;

final class PhoneRule extends RuleAbstract implements RuleInterface
{
    public function attribute(): string
    {
        return 'baz';
    }

    public function validate(): bool
    {
        return preg_match('/^8 \(\d{3}\) \d{3}-\d{2}-\d{2}$/', $this->value);
    }

    public function rebirth(): string
    {
        return preg_replace('/[^0-9]/', '', '7' . ltrim($this->value, 8));
    }
}