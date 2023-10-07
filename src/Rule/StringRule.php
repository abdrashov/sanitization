<?php

namespace Abdrashov\Sanitization\Rule;

use Abdrashov\Sanitization\Rule\Abstract\RuleAbstract;
use Abdrashov\Sanitization\Rule\Interface\RuleInterface;

final class StringRule extends RuleAbstract implements RuleInterface
{
    public function attribute(): string
    {
        return 'bar';
    }

    public function validate(): bool
    {
        return !preg_match('/\d/', $this->value);
    }

    public function rebirth(): string
    {
        return $this->value;
    }
}